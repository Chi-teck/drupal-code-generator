<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Exception\ExceptionInterface;
use DrupalCodeGenerator\GeneratorDefinition;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Interviewer\Interviewer;
use DrupalCodeGenerator\IOAwareInterface;
use DrupalCodeGenerator\IOAwareTrait;
use DrupalCodeGenerator\Logger\ConsoleLogger;
use DrupalCodeGenerator\Style\GeneratorStyle;
use DrupalCodeGenerator\Utils;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Base class for code generators.
 */
abstract class Generator extends Command implements GeneratorInterface, IOAwareInterface, LoggerAwareInterface {

  use IOAwareTrait;
  use LoggerAwareTrait;
  use LegacyTrait;

  /**
   * The API version.
   */
  protected static int $api;

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
   * {@inheritdoc}
   */
  protected function initialize(InputInterface $input, OutputInterface $output): void {
    parent::initialize($input, $output);

    /** @var \DrupalCodeGenerator\Helper\QuestionHelper $question_helper */
    $logger = new ConsoleLogger($output);
    $question_helper = $this->getHelper('question');
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
      $this->getHelper('renderer')->prependPath($this->templatePath);
    }

    $this->directory = $input->getOption('working-dir') ?: \getcwd();

    $this->logger->debug('Working directory: {directory}', ['directory' => $this->directory]);
  }

  /**
   * {@inheritdoc}
   *
   * @noinspection PhpMissingParentCallCommonInspection
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {

    $this->logger->debug('Command: {command}', ['command' => static::class]);

    try {
      $this->printHeader();

      $vars = [];
      $assets = new AssetCollection();
      $this->generate($vars, $assets);

      $vars = self::processVars($vars);
      $collected_vars = \preg_replace('/^Array/', '', \print_r($vars, TRUE));
      $this->logger->debug('Collected variables: {vars}', ['vars' => $collected_vars]);

      foreach ($assets as $asset) {
        // Local asset variables take precedence over global ones.
        $asset->vars(\array_merge($vars, $asset->getVars()));
      }

      $this->render($assets);

      // Destination passed through command line option takes precedence over
      // destination defined in a generator.
      $destination = $input->getOption('destination') ?: $this->getDestination($vars);
      $this->logger->debug('Destination directory: {directory}', ['directory' => $destination]);

      $full_path = $input->getOption('full-path');
      $dry_run = $input->getOption('dry-run');
      $dumped_assets = $this->dump($assets, $destination, $dry_run, $full_path);

      $this->printSummary($dumped_assets, $full_path ? $destination . '/' : '');
    }
    catch (ExceptionInterface $exception) {
      $this->io()->getErrorStyle()->error($exception->getMessage());
      return self::FAILURE;
    }

    $this->logger->debug('Memory usage: {memory}', ['memory' => Helper::formatMemory(\memory_get_peak_usage())]);

    return self::SUCCESS;
  }

  /**
   * Generates assets.
   */
  abstract protected function generate(array &$vars, AssetCollection $assets): void;

  protected function getGeneratorDefinition(): GeneratorDefinition {
    // Detect type from legacy properties.
    $type = match ($this->extensionType) {
      DrupalGenerator::EXTENSION_TYPE_MODULE => $this->isNewExtension ? GeneratorType::MODULE : GeneratorType::MODULE_COMPONENT,
      DrupalGenerator::EXTENSION_TYPE_THEME => $this->isNewExtension ? GeneratorType::THEME : GeneratorType::THEME_COMPONENT,
      default => GeneratorType::OTHER,
    };
    return new GeneratorDefinition(
      type: $type,
      templatePath: $this->templatePath,
      label: \method_exists($this, 'getLabel') ? $this->getLabel() : NULL,
    );
  }

  protected function createInterviewer(array &$vars): Interviewer {
    return new Interviewer(
      io: $this->io,
      vars: $vars,
      generatorDefinition: $this->getGeneratorDefinition(),
      moduleInfo: $this->getHelper('module_info'),
      themeInfo: $this->getHelper('theme_info'),
      serviceInfo: $this->getHelper('service_info'),
    );
  }

  /**
   * Render assets.
   */
  protected function render(AssetCollection $assets): void {
    $renderer = $this->getHelper('renderer');
    foreach ($assets->getFiles() as $asset) {
      $renderer->renderAsset($asset);
    }
  }

  /**
   * Dumps assets.
   */
  protected function dump(AssetCollection $assets, string $destination, bool $dry_run, bool $full_path): AssetCollection {
    $options = new DumperOptions(NULL, $dry_run, $full_path);
    return $this->getHelper('dumper')->dump($assets, $destination, $options);
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
  public function getLabel(): string {
    return $this->label;
  }

  /**
   * Processes collected variables.
   */
  private static function processVars(array $vars): array {
    $processor = static function (&$var, string $key, array $vars): void {
      if (\is_string($var)) {
        $var = Utils::stripSlashes(Utils::replaceTokens($var, $vars));
      }
    };
    \array_walk_recursive($vars, $processor, $vars);
    return $vars;
  }

  /**
   * Returns destination for generated files.
   */
  protected function getDestination(array $vars): ?string {
    // @todo Figure out the case when machine name is not provided.
    return match ($this->extensionType) {
      DrupalGenerator::EXTENSION_TYPE_MODULE => $this->getHelper('module_info')
        ->getDestination($this->isNewExtension, $vars['machine_name']),
      DrupalGenerator::EXTENSION_TYPE_THEME => $this->getHelper('theme_info')
        ->getDestination($this->isNewExtension, $vars['machine_name']),
      default => $this->directory,
    };
  }

}
