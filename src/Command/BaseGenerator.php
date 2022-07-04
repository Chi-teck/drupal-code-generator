<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator as GeneratorDefinition;
use DrupalCodeGenerator\Exception\ExceptionInterface;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\InputOutput\Interviewer;
use DrupalCodeGenerator\InputOutput\IO;
use DrupalCodeGenerator\InputOutput\IOAwareInterface;
use DrupalCodeGenerator\InputOutput\IOAwareTrait;
use DrupalCodeGenerator\Logger\ConsoleLogger;
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
abstract class BaseGenerator extends Command implements LabelInterface, IOAwareInterface, LoggerAwareInterface {

  use IOAwareTrait;
  use LoggerAwareTrait;

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    parent::configure();
    $definition = $this->getGeneratorDefinition();
    $this->setName($definition->name)
      ->setDescription($definition->description)
      ->setAliases($definition->aliases)
      ->setHidden($definition->hidden);
  }

  /**
   * {@inheritdoc}
   */
  protected function initialize(InputInterface $input, OutputInterface $output): void {
    parent::initialize($input, $output);

    $logger = new ConsoleLogger($output);
    $question_helper = $this->getHelper('question');
    $io = new IO($input, $output, $question_helper);

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

    $template_path = $this->getGeneratorDefinition()->templatePath;
    if ($template_path !== NULL) {
      $this->getHelper('renderer')->registerTemplatePath($template_path);
    }

    $this->logger->debug('Working directory: {directory}', ['directory' => $this->getWorkingDirectory()]);
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

      $vars = Utils::processVars($vars);
      $collected_vars = \preg_replace('/^Array/', '', \print_r($vars, TRUE));
      $this->logger->debug('Collected variables: {vars}', ['vars' => $collected_vars]);

      foreach ($assets as $asset) {
        // Local asset variables take precedence over global ones.
        $asset->vars(\array_merge($vars, Utils::processVars($asset->getVars())));
      }

      $this->render($assets);

      // Destination passed through command line option takes precedence over
      // destination defined in a generator.
      $destination = $input->getOption('destination') ?: $this->getDestination($vars);
      $this->logger->debug('Destination directory: {directory}', ['directory' => $destination]);

      $dumped_assets = $this->dump($assets, $destination);

      $full_path = $input->getOption('full-path');
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
    $attributes = (new \ReflectionClass(static::class))->getAttributes(GeneratorDefinition::class);
    if (\count($attributes) === 0) {
      throw new \LogicException(\sprintf('Command %s does not have generator annotation.', static::class));
    }
    /** @noinspection PhpIncompatibleReturnTypeInspection */
    return $attributes[0]->newInstance();
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
  protected function dump(AssetCollection $assets, string $destination): AssetCollection {
    $is_dry = $this->io()->getInput()->getOption('dry-run');
    $dumper_name = $is_dry ? 'dry_dumper' : 'filesystem_dumper';
    $dumped_assets = $this->getHelper($dumper_name)->dump($assets, $destination);
    if (!$is_dry) {
      $this->getHelper('rector')->process($dumped_assets, $destination);
    }
    return $dumped_assets;
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
    return $this->getGeneratorDefinition()->label;
  }

  /**
   * Returns destination for generated files.
   *
   * @todo Test this.
   */
  protected function getDestination(array $vars): ?string {
    if (!isset($vars['machine_name'])) {
      return $this->getWorkingDirectory();
    }
    $definition = $this->getGeneratorDefinition();
    $is_new = $definition->type->isNewExtension();
    return match ($definition->type) {
      GeneratorType::MODULE, GeneratorType::MODULE_COMPONENT =>
        $this->getHelper('module_info')->getDestination($vars['machine_name'], $is_new),
      GeneratorType::THEME, GeneratorType::THEME_COMPONENT =>
        $this->getHelper('theme_info')->getDestination($vars['machine_name'], $is_new),
      default => $this->getWorkingDirectory(),
    };
  }

  /**
   * Returns current working directory.
   *
   * Can be helpful to supply generators with some context. For instance, the
   * directory name can be used to set default extension name.
   */
  final protected function getWorkingDirectory(): string {
    return $this->io->getInput()->getOption('working-dir') ?? \getcwd();
  }

}
