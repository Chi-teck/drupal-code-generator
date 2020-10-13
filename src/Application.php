<?php

namespace DrupalCodeGenerator;

use DrupalCodeGenerator\Helper\DrupalContext;
use DrupalCodeGenerator\Helper\Dumper;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\Helper\ResultPrinter;
use DrupalCodeGenerator\Logger\ConsoleLogger;
use DrupalCodeGenerator\Style\GeneratorStyle;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use Psr\Log\LoggerAwareInterface;
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
  protected function doRunCommand(Command $command, InputInterface $input, OutputInterface $output): int {
    $helper_set = $this->getHelperSet();

    /** @var \DrupalCodeGenerator\Helper\QuestionHelper $question_helper */
    $logger = new ConsoleLogger($output);
    $question_helper = $helper_set->get('question');
    $io = new GeneratorStyle($input, $output, $question_helper);

    $items = \iterator_to_array($this->getHelperSet());
    $items[] = $command;
    foreach ($items as $item) {
      if ($item instanceof IOAwareInterface) {
        $item->io($io);
      }
      if ($item instanceof LoggerAwareInterface) {
        $item->setLogger($logger);
      }
    }

    return parent::doRunCommand($command, $input, $output);
  }

}
