<?php

namespace DrupalCodeGenerator;

use DrupalCodeGenerator\Helper\DrupalContext;
use DrupalCodeGenerator\Helper\Dumper;
use DrupalCodeGenerator\Helper\LoggerFactory;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\Helper\ResultPrinter;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Loader\FilesystemLoader;

/**
 * Console application.
 */
class Application extends BaseApplication {

  /**
   * Path to DCG root directory.
   */
  public const ROOT = __DIR__ . '/..';

  /**
   * Path to templates directory.
   */
  public const TEMPLATE_PATH = Application::ROOT . '/templates/';

  /**
   * Creates the application.
   */
  public static function create(?ContainerInterface $container = NULL): Application {
    // This gets substituted with git version when DCG is packaged to PHAR file.
    $version = '@git-version@';
    // Fallback for composer installation.
    if (!is_numeric($version[0])) {
      $version = 'UNKNOWN';
    }
    $application = new static('Drupal Code Generator', $version);

    $helper_set = new HelperSet([
      new QuestionHelper(),
      new Dumper(new Filesystem()),
      new Renderer(new TwigEnvironment(new FilesystemLoader())),
      new ResultPrinter(FALSE),
      new LoggerFactory(),
    ]);

    if ($container) {
      $helper_set->set(new DrupalContext($container));
    }
    $application->setHelperSet($helper_set);

    return $application;
  }

  /**
   * Adds default DCG options to the command.
   */
  public static function addDefaultOptions(Command $command): void {
    $command
      ->addOption('working-dir', '-d', InputOption::VALUE_OPTIONAL, 'Working directory')
      ->addOption('answer', '-a', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'Answer to generator question')
      ->addOption('dry-run', NULL, InputOption::VALUE_NONE, 'Output the generated code but not save it to file system')
      ->addOption('destination', NULL, InputOption::VALUE_OPTIONAL, 'Path to a base directory for file writing');
  }

}
