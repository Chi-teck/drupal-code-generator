<?php

namespace DrupalCodeGenerator;

use DrupalCodeGenerator\Helper\Dumper;
use DrupalCodeGenerator\Helper\InputHandler;
use DrupalCodeGenerator\Helper\ResultPrinter;
use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use DrupalCodeGenerator\Helper\QuestionHelper;
use Symfony\Component\Filesystem\Filesystem;

/**
 * DCG application factory.
 */
class ApplicationFactory {

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
   * Creates an application.
   *
   * @return \Symfony\Component\Console\Application
   *   The initialized console application.
   */
  public static function create() :Application {
    // This gets substituted with git version when DCG is packaged to PHAR file.
    $version = '@git-version@';
    // Fallback for composer installation.
    if (!is_numeric($version[0])) {
      $version = 'UNKNOWN';
    }
    $application = new Application('Drupal Code Generator', $version);

    $helper_set = new HelperSet([
      new QuestionHelper(),
      new Dumper(new Filesystem()),
      new Renderer(new TwigEnvironment(new \Twig_Loader_Filesystem())),
      new InputHandler(),
      new ResultPrinter(),
    ]);
    $application->setHelperSet($helper_set);

    return $application;
  }

}
