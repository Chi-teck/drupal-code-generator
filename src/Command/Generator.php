<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Exception\ExceptionInterface;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\IOAwareInterface;
use DrupalCodeGenerator\IOAwareTrait;
use DrupalCodeGenerator\Logger\ConsoleLogger;
use DrupalCodeGenerator\Style\GeneratorStyle;
use DrupalCodeGenerator\Utils;
use DrupalCodeGenerator\ValidatorTrait;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Base class for code generators.
 */
abstract class Generator extends Command implements GeneratorInterface, IOAwareInterface, LoggerAwareInterface, LabelInterface {

  use IOAwareTrait;
  use LoggerAwareTrait;
  use ValidatorTrait;

  /**
   * The command name.
   */
  protected string $name;

  /**
   * The command description.
   */
  protected string $description;

  /**
   * The command alias.
   */
  protected string $alias = '';

  /**
   * A human-readable name of the generator.
   */
  protected string $label = '';

  /**
   * A path where templates are stored.
   */
  protected string $templatePath = '';

  /**
   * The working directory.
   *
   * This is used to supply generators with some context. For instance, the
   * directory name can be used to set default extension name.
   */
  protected string $directory;

  /**
   * Assets to create.
   */
  protected AssetCollection $assets;

  /**
   * Twig template variables.
   *
   * @var array
   */
  private array $vars;

  /**
   * {@inheritdoc}
   */
  protected function configure(): void {
    $this
      ->setName($this->name)
      ->setDescription($this->description)
      ->setAliases($this->alias ? [$this->alias] : []);
  }

  /**
   * {@inheritdoc}
   */
  protected function initialize(InputInterface $input, OutputInterface $output): void {

    $this->assets = new AssetCollection();

    $helper_set = $this->getHelperSet();

    /** @var \DrupalCodeGenerator\Helper\QuestionHelper $question_helper */
    $logger = new ConsoleLogger($output);
    $question_helper = $helper_set->get('question');
    $io = new GeneratorStyle($input, $output, $question_helper);

    $items = \iterator_to_array($this->getHelperSet());
    $items[] = $this;
    foreach ($items as $item) {
      if ($item instanceof IOAwareInterface) {
        $item->io($io);
      }
      if ($item instanceof LoggerAwareInterface) {
        $item->setLogger($logger);
      }
    }

    if ($this->templatePath) {
      $this->getHelper('renderer')->addPath($this->templatePath);
    }
    else {
      // This is specific to DCG core generators. Third-party generators should
      // always define template path.
      $template_path = Application::TEMPLATE_PATH . \str_replace(':', '/', $this->getName());
      if (\file_exists($template_path) && \is_dir($template_path)) {
        $this->getHelper('renderer')->addPath($template_path);
        // Also add default template path as some generators may share their
        // templates.
        $this->getHelper('renderer')->addPath(Application::TEMPLATE_PATH);
      }
      else {
        throw new \LogicException('Template path is not specified.');
      }
    }

    $this->directory = $input->getOption('working-dir') ?: \getcwd();

    $this->logger->debug('Working directory: {directory}', ['directory' => $this->directory]);
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    $this->logger->debug('Command: {command}', ['command' => static::class]);

    try {
      $this->printHeader();

      $vars = $this->getDefaultVars();
      // Use class property to make vars available for IO helpers.
      $this->vars = &$vars;
      $this->generate($vars);

      $vars = self::processVars($vars);
      $collected_vars = \preg_replace('/^Array/', '', \print_r($vars, TRUE));
      $this->logger->debug('Collected variables: {vars}', ['vars' => $collected_vars]);

      $this->processAssets($vars);

      $this->render();

      // Destination passed through command line option takes precedence over
      // destination defined in a generator.
      $destination = $input->getOption('destination') ?: $this->getDestination($vars);
      $this->logger->debug('Destination directory: {directory}', ['directory' => $destination]);

      $full_path = $input->getOption('full-path');
      $dry_run = $input->getOption('dry-run');
      $dumped_assets = $this->dump($destination, $dry_run, $full_path);

      $this->printSummary($dumped_assets, $full_path ? $destination . '/' : '');
    }
    catch (ExceptionInterface $exception) {
      $this->io()->getErrorStyle()->error($exception->getMessage());
      return 1;
    }

    $this->logger->debug('Memory usage: {memory}', ['memory' => Helper::formatMemory(\memory_get_peak_usage())]);

    return 0;
  }

  /**
   * Generates assets.
   */
  abstract protected function generate(array &$vars): void;

  /**
   * Render assets.
   */
  protected function render(): void {
    $renderer = $this->getHelper('renderer');
    foreach ($this->assets->getFiles() as $asset) {
      // Supply the asset with all collected variables if it has no local ones.
      if (!$asset->getVars()) {
        $asset->vars($this->vars);
      }
      $renderer->renderAsset($asset);
    }
  }

  /**
   * Dumps assets.
   */
  protected function dump(string $destination, bool $dry_run, bool $full_path): AssetCollection {
    $options = new DumperOptions(TRUE, $dry_run, $full_path);
    return $this->getHelper('dumper')->dump($this->assets, $destination, $options);
  }

  /**
   * Prints header.
   */
  protected function printHeader(): void {
    $this->io->title(\sprintf('Welcome to %s generator!', $this->getAliases()[0] ?? $this->getName()));
  }

  /**
   * Prints summary.
   */
  protected function printSummary(AssetCollection $dumped_assets, string $base_path): void {
    $this->getHelper('result_printer')->printResult($dumped_assets, $base_path);
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel(): ?string {
    return $this->label;
  }

  /**
   * Asks a question.
   *
   * @param string $question
   *   A question to ask.
   * @param string|null $default
   *   The default answer to return if the user enters nothing.
   * @param mixed $validator
   *   A validator for the question.
   *
   * @return mixed
   *   The user answer
   */
  protected function ask(string $question, ?string $default = NULL, $validator = NULL) {
    $question = Utils::stripSlashes(Utils::replaceTokens($question, $this->vars));
    if ($default) {
      $default = Utils::stripSlashes(Utils::replaceTokens($default, $this->vars));
    }

    // Allow the validators to be referenced in a short form like
    // '::validateMachineName'.
    if (\is_string($validator) && \str_starts_with($validator, '::')) {
      $validator = [static::class, \substr($validator, 2)];
    }
    return $this->io->ask($question, $default, $validator);
  }

  /**
   * Asks for confirmation.
   */
  protected function confirm(string $question, bool $default = TRUE): bool {
    $question = Utils::stripSlashes(Utils::replaceTokens($question, $this->vars));
    return (bool) $this->io->confirm($question, $default);
  }

  /**
   * Asks a choice question.
   *
   * @param string $question
   *   A question to ask.
   * @param array $choices
   *   The list of available choices.
   * @param string|null $default
   *   The default answer to return if the user enters nothing.
   *
   * @return mixed
   *   The user answer
   */
  protected function choice(string $question, array $choices, ?string $default = NULL) {
    $question = Utils::stripSlashes(Utils::replaceTokens($question, $this->vars));

    // The choices can be an associative array.
    $choice_labels = \array_values($choices);
    // Start choices list form '1'.
    \array_unshift($choice_labels, NULL);
    unset($choice_labels[0]);

    // Do not use IO choice here as it prints choice key as default value.
    // @see \Symfony\Component\Console\Style\SymfonyStyle::choice().
    $answer = $this->io->askQuestion(new ChoiceQuestion($question, $choice_labels, $default));
    return \array_search($answer, $choices);
  }

  /**
   * Creates a directory asset.
   *
   * @param string $path
   *   (Optional) Directory path.
   *
   * @return \DrupalCodeGenerator\Asset\Directory
   *   The directory asset.
   */
  protected function addDirectory(string $path): Directory {
    return $this->assets[] = new Directory($path);
  }

  /**
   * Creates a file asset.
   *
   * @param string $path
   *   (Optional) File path.
   * @param string|null $template
   *   (Optional) Template.
   *
   * @return \DrupalCodeGenerator\Asset\File
   *   The file asset.
   */
  protected function addFile(string $path, ?string $template = NULL): File {
    $asset = new File($path);
    $asset->template($template);
    return $this->assets[] = $asset;
  }

  /**
   * Creates a symlink asset.
   *
   * @param string $path
   *   Symlink path.
   * @param string $target
   *   Symlink target.
   *
   * @return \DrupalCodeGenerator\Asset\File
   *   The file asset.
   */
  protected function addSymlink(string $path, string $target): Symlink {
    $asset = new Symlink($path, $target);
    return $this->assets[] = $asset;
  }

  /**
   * Processes collected variables.
   */
  private static function processVars(array $vars): array {
    $process_vars = static function (&$var, string $key, array $vars): void {
      if (\is_string($var)) {
        $var = Utils::stripSlashes(Utils::replaceTokens($var, $vars));
      }
    };
    \array_walk_recursive($vars, $process_vars, $vars);
    return $vars;
  }

  /**
   * Processes collected assets.
   */
  private function processAssets(array $vars): void {
    foreach ($this->assets as $asset) {
      // Local asset variables take precedence over global ones.
      $asset->vars(\array_merge($vars, $asset->getVars()));
    }
  }

  /**
   * Returns destination for generated files.
   */
  protected function getDestination(array $vars): ?string {
    return $this->directory;
  }

  /**
   * Returns default template variables.
   */
  protected function getDefaultVars(): array {
    return [];
  }

}
