<?php declare(strict_types=1);

namespace DrupalCodeGenerator;

use Drupal\Core\DependencyInjection\ContainerNotInitializedException;
use DrupalCodeGenerator\Helper\DrupalContext;
use DrupalCodeGenerator\Helper\Dumper;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\Helper\ResultPrinter;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Loader\FilesystemLoader;

/**
 * DCG console application.
 */
class Application extends BaseApplication implements ContainerAwareInterface {

  use ContainerAwareTrait;

  /**
   * Path to DCG root directory.
   */
  public const ROOT = __DIR__ . '/..';

  /**
   * DCG version.
   */
  public const VERSION = '3.0.0-dev';

  /**
   * DCG API version.
   */
  public const API = 3;

  /**
   * Path to templates directory.
   */
  public const TEMPLATE_PATH = Application::ROOT . '/templates';

  /**
   * Creates the application.
   */
  public static function create(ContainerInterface $container): Application {
    $application = new static('Drupal Code Generator', self::VERSION);
    $application->setContainer($container);

    $helper_set = new HelperSet([
      new QuestionHelper(),
      new Dumper(new Filesystem()),
      new Renderer(new TwigEnvironment(new FilesystemLoader([Application::TEMPLATE_PATH]))),
      new ResultPrinter(),
      new DrupalContext($container),
    ]);
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

  public function getContainer(): ContainerInterface {
    if (!$this->container) {
      throw new ContainerNotInitializedException('Application::$container is not initialized yet.');
    }
    return $this->container;
  }

}
