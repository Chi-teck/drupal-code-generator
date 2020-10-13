<?php

namespace DrupalCodeGenerator;

use DrupalCodeGenerator\Helper\DrupalContext;
use DrupalCodeGenerator\Helper\Dumper;
use DrupalCodeGenerator\Helper\LoggerFactory;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\Helper\ResultPrinter;
use DrupalCodeGenerator\Style\GeneratorStyle;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Loader\FilesystemLoader;

/**
 * DCG console application.
 */
class Application extends BaseApplication {

  /**
   * Path to DCG root directory.
   */
  public const ROOT = __DIR__ . '/..';

  /**
   * DCG version.
   */
  public const VERSION = '2.0.0-dev';

  /**
   * Path to templates directory.
   */
  public const TEMPLATE_PATH = Application::ROOT . '/templates/';

  /**
   * Creates the application.
   */
  public static function create(?ContainerInterface $container = NULL): Application {
    $application = new static('Drupal Code Generator', self::VERSION);

    $helper_set = new HelperSet([
      new QuestionHelper(),
      new Dumper(new Filesystem()),
      new Renderer(new TwigEnvironment(new FilesystemLoader())),
      new ResultPrinter(),
      new LoggerFactory(),
    ]);

    if ($container) {
      $helper_set->set(new DrupalContext($container));
    }
    $application->setHelperSet($helper_set);

    return $application;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultInputDefinition(): InputDefinition {
    $definition = parent::getDefaultInputDefinition();

    $options = $definition->getOptions();
    // As most generators are interactive these options make no sense.
    unset($options['no-interaction'], $options['quiet']);
    $definition->setOptions($options);

    $definition->addOption(new InputOption('working-dir', 'd', InputOption::VALUE_OPTIONAL, 'Working directory'));
    $definition->addOption(new InputOption('answer', 'a', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'Answer to generator question'));
    $definition->addOption(new InputOption('dry-run', NULL, InputOption::VALUE_NONE, 'Output the generated code but not save it to file system'));
    $definition->addOption(new InputOption('full-path', NULL, InputOption::VALUE_NONE, 'Print full path to generated assets'));
    $definition->addOption(new InputOption('destination', NULL, InputOption::VALUE_OPTIONAL, 'Path to a base directory for file writing'));
    return $definition;
  }

  /**
   * {@inheritdoc}
   */
  protected function doRunCommand(Command $command, InputInterface $input, OutputInterface $output) {
    $helper_set = $this->getHelperSet();

    /** @var \DrupalCodeGenerator\Helper\QuestionHelper $question_helper */
    $question_helper = $helper_set->get('question');
    $io = new GeneratorStyle($input, $output, $question_helper);

    $logger = $helper_set->get('logger_factory')->getLogger($io);

    foreach ($this->getHelperSet() as $helper) {
      self::initObject($helper, $logger, $io);
    }
    self::initObject($command, $logger, $io);

    return parent::doRunCommand($command, $input, $output);
  }

  /**
   * Sets objects dependencies.
   */
  private static function initObject(Object $object, LoggerInterface $logger, GeneratorStyleInterface $io): void {
    if ($object instanceof IOAwareInterface) {
      $object->io($io);
    }
    if ($object instanceof LoggerAwareInterface) {
      $object->setLogger($logger);
    }
  }

}
