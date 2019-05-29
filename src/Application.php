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
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Loader\FilesystemLoader;

/**
 * Console application.
 */
class Application extends BaseApplication {

  /**
   * Path to DCG root directory.
   */
  const ROOT = __DIR__ . '/..';

  /**
   * Path to templates directory.
   */
  const TEMPLATE_PATH = Application::ROOT . '/templates/';

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
      new Renderer(new TwigEnvironment(new FilesystemLoader())),
      new ResultPrinter(),
      new LoggerFactory(),
    ]);

    if (class_exists('Drupal')) {
      $helper_set->set(new DrupalContext(\Drupal::getContainer()));
    }
    $application->setHelperSet($helper_set);

    return $application;
  }

}
