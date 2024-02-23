<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator as GeneratorDefinition;
use DrupalCodeGenerator\Event\AssetPostProcess;
use DrupalCodeGenerator\Event\AssetPreProcess;
use DrupalCodeGenerator\Exception\ExceptionInterface;
use DrupalCodeGenerator\Exception\SilentException;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Helper\Drupal\NullExtensionInfo;
use DrupalCodeGenerator\InputOutput\DefaultOptions;
use DrupalCodeGenerator\InputOutput\Interviewer;
use DrupalCodeGenerator\InputOutput\IO;
use DrupalCodeGenerator\InputOutput\IOAwareInterface;
use DrupalCodeGenerator\InputOutput\IOAwareTrait;
use DrupalCodeGenerator\Logger\ConsoleLogger;
use DrupalCodeGenerator\Utils;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Base class for code generators.
 *
 * @method \DrupalCodeGenerator\Application getApplication()
 * @method string getName()
 * @method \Symfony\Component\Console\Helper\HelperSet getHelperSet()
 */
abstract class BaseGenerator extends Command implements LabelInterface, IOAwareInterface, LoggerAwareInterface {

  use IOAwareTrait;
  use LoggerAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function __construct() {
    parent::__construct();
    $this->logger = new NullLogger();
  }

  /**
   * {@inheritdoc}
   */
  protected function configure(): void {
    parent::configure();
    $definition = $this->getGeneratorDefinition();
    $this->setName($definition->name)
      ->setDescription($definition->description)
      ->setAliases($definition->aliases)
      ->setHidden($definition->hidden);
    DefaultOptions::apply($this);
  }

  /**
   * {@inheritdoc}
   *
   * @psalm-suppress PossiblyNullReference
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

    $template_path = $this->getTemplatePath();
    if ($template_path !== NULL) {
      $this->getHelper('renderer')->registerTemplatePath($template_path);
    }

    $this->logger->debug('PHP binary: {binary}', ['binary' => \PHP_BINARY]);
    /** @psalm-var array{PHP_SELF: string} $_SERVER */
    // @phpcs:ignore SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable
    $this->logger->debug('DCG executable: {dcg}', ['dcg' => \realpath($_SERVER['PHP_SELF'])]);
    $this->logger->debug('Working directory: {directory}', ['directory' => $io->getWorkingDirectory()]);
  }

  /**
   * {@inheritdoc}
   *
   * @noinspection PhpMissingParentCallCommonInspection
   * @psalm-suppress PossiblyNullReference
   *
   * @psalm-return int<0, 1>
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {

    $this->logger->debug('Command: {command}', ['command' => static::class]);

    try {
      $this->printHeader();

      $vars = [];
      $assets = new AssetCollection();
      $this->generate($vars, $assets);
      $this->generateInfoFile($vars, $assets);

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
      if (!$exception instanceof SilentException) {
        $this->io()->getErrorStyle()->error($exception->getMessage());
      }
      return self::FAILURE;
    }

    $this->logger->debug('Memory usage: {memory}', ['memory' => Helper::formatMemory(\memory_get_peak_usage())]);

    return self::SUCCESS;
  }

  /**
   * Generates assets.
   */
  abstract protected function generate(array &$vars, AssetCollection $assets): void;

  /**
   * Gets generator definition.
   */
  protected function getGeneratorDefinition(): GeneratorDefinition {
    $attributes = (new \ReflectionClass(static::class))->getAttributes(GeneratorDefinition::class);
    if (\count($attributes) === 0) {
      throw new \LogicException(\sprintf('Command %s does not have generator annotation.', static::class));
    }
    return $attributes[0]->newInstance();
  }

  /**
   * Creates interviewer.
   */
  protected function createInterviewer(array &$vars): Interviewer {
    $extension_info = match ($this->getGeneratorDefinition()->type) {
      GeneratorType::MODULE, GeneratorType::MODULE_COMPONENT => $this->getHelper('module_info'),
      GeneratorType::THEME, GeneratorType::THEME_COMPONENT => $this->getHelper('theme_info'),
      default => new NullExtensionInfo(),
    };
    return new Interviewer(
      io: $this->io,
      vars: $vars,
      generatorDefinition: $this->getGeneratorDefinition(),
      serviceInfo: $this->getHelper('service_info'),
      extensionInfo: $extension_info,
      permissionInfo: $this->getHelper('permission_info'),
    );
  }

  /**
   * Render assets.
   */
  protected function render(AssetCollection $assets): void {
    $renderer = $this->getHelper('renderer');
    foreach ($assets->getFiles() as $file) {
      /** @var \DrupalCodeGenerator\Asset\File $file */
      $renderer->renderAsset($file);
    }
  }

  /**
   * Dumps assets.
   */
  protected function dump(AssetCollection $assets, string $destination): AssetCollection {
    $is_dry = $this->io()->getInput()->getOption('dry-run');

    $pre_process_event = $this->getApplication()->dispatch(
      new AssetPreProcess($assets, $destination, $this->getName(), $is_dry),
    );
    $assets = $pre_process_event->assets;
    $destination = $pre_process_event->destination;

    /** @var \DrupalCodeGenerator\Helper\Dumper\DumperInterface $dumper */
    $dumper = $this->getHelper($is_dry ? 'dry_dumper' : 'filesystem_dumper');
    $dumped_assets = $dumper->dump($assets, $destination);

    $post_process_event = $this->getApplication()->dispatch(
      new AssetPostProcess($dumped_assets, $destination, $this->getName(), $is_dry),
    );
    return $post_process_event->assets;
  }

  /**
   * Prints header.
   */
  protected function printHeader(): void {
    $this->io()->title(\sprintf('Welcome to %s generator!', $this->getAliases()[0] ?? $this->getName()));
  }

  /**
   * Prints summary.
   */
  protected function printSummary(AssetCollection $dumped_assets, string $base_path): void {
    $printer_name = $this->io()->isVerbose() ? 'assets_table_printer' : 'assets_list_printer';
    /** @psalm-suppress UndefinedInterfaceMethod */
    $this->getHelper($printer_name)->printAssets($dumped_assets, $base_path);
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel(): ?string {
    return $this->getGeneratorDefinition()->label;
  }

  /**
   * Returns template path.
   */
  final protected function getTemplatePath(): ?string {
    return $this->getGeneratorDefinition()->templatePath;
  }

  /**
   * Returns destination for generated files.
   *
   * @todo Test this.
   */
  protected function getDestination(array $vars): string {
    if (!isset($vars['machine_name'])) {
      return $this->io()->getWorkingDirectory();
    }
    $definition = $this->getGeneratorDefinition();
    $is_new = $definition->type->isNewExtension();
    return match ($definition->type) {
      GeneratorType::MODULE, GeneratorType::MODULE_COMPONENT =>
        $this->getHelper('module_info')->getDestination($vars['machine_name'], $is_new),
      GeneratorType::THEME, GeneratorType::THEME_COMPONENT =>
        $this->getHelper('theme_info')->getDestination($vars['machine_name'], $is_new),
      default => $this->io()->getWorkingDirectory(),
    };
  }

  /**
   * Generates info file.
   *
   * @todo Test this.
   * @todo Generate info file for theme components.
   */
  protected function generateInfoFile(array &$vars, AssetCollection $assets): void {
    if (\count($assets) === 0) {
      return;
    }
    if ($this->getGeneratorDefinition()->type !== GeneratorType::MODULE_COMPONENT) {
      return;
    }

    // @todo Throw an exception if machine name was not provided.
    /** @psalm-suppress PossiblyUndefinedStringArrayOffset */
    $vars['name'] ??= Utils::machine2human($vars['machine_name']);
    $info_template = <<< 'TWIG'
      name: '{{ name }}'
      type: module
      description: '@todo Add description.'
      package: '@todo Add package'
      core_version_requirement: ^10

      TWIG;
    $assets->addFile('{machine_name}.info.yml')
      ->inlineTemplate($info_template)
      ->preserveIfExists();
  }

}
