<?php

namespace DrupalCodeGenerator;

use DrupalCodeGenerator\Helper\Dumper;
use DrupalCodeGenerator\Helper\InputHandler;
use DrupalCodeGenerator\Helper\LoggerFactory;
use DrupalCodeGenerator\Helper\OutputStyleFactory;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\Helper\ResultPrinter;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Console application.
 */
class Application extends BaseApplication {

  /**
   * Determines path to DCG root directory.
   *
   * @return string
   *   Path to DCG root directory.
   */
  public static function getRoot() :string {
    return dirname(__DIR__);
  }

  /**
   * Creates the application.
   */
  public static function create() :Application {
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
      new Renderer(new TwigEnvironment(new \Twig_Loader_Filesystem())),
      new InputHandler(),
      new ResultPrinter(),
      new LoggerFactory(),
      new OutputStyleFactory(),
    ]);
    $application->setHelperSet($helper_set);

    return $application;
  }

}
