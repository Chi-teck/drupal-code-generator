<?php

/**
 * @file
 * Globals.
 */

use DrupalCodeGenerator\ApplicationFactory;
use DrupalCodeGenerator\Twig\Twig1Environment;
use DrupalCodeGenerator\Twig\Twig2Environment;
use Twig\Environment;

/**
 * DCG root.
 *
 * @deprecated
 *   Use DrupalCodeGenerator\ApplicationFactory::getRoot
 */
define('DCG_ROOT', dirname(__DIR__));

/**
 * Creates an application.
 *
 * @return \Symfony\Component\Console\Application
 *   The initialized console application.
 *
 * @deprecated
 *   Use DrupalCodeGenerator\ApplicationFactory::create
 *
 * @codeCoverageIgnore
 */
function dcg_create_application() {
  return ApplicationFactory::create();
}

/**
 * Creates an Twig environment.
 */
function dcg_get_twig_environment($loader) {
  switch (Environment::MAJOR_VERSION) {
    case 1:
      $environment = new Twig1Environment($loader);
      break;

    case 2:
      $environment = new Twig2Environment($loader);
      break;

    default:
      throw new \RuntimeException('Unsupported Twig version');
  }
  return $environment;
}

// Determine major Twig version.
// \Twig\Environment::MAJOR_VERSION is not suitable here because of
// https://github.com/twigphp/Twig/pull/2945
// Use this workaround as drupal/drupal is locked on Twig 1.38.
list($twig_major_version) = sscanf(Environment::VERSION, '%d.%d.%d');

// \Twig\Environment::tokenize() signature has been changed in Twig 2, so that
// it is not possible to maintain the same \Twig\Environment sub-class for both
// Twig versions.
$twig_environment_class = sprintf('DrupalCodeGenerator\Twig\Twig%dEnvironment', $twig_major_version);
if (!class_exists('DrupalCodeGenerator\Twig\TwigEnvironment')) {
  class_alias($twig_environment_class, 'DrupalCodeGenerator\Twig\TwigEnvironment');
}

// Legacy TwigEnvironment class is still used in Drush.
if (!class_exists('DrupalCodeGenerator\TwigEnvironment')) {
  class_alias($twig_environment_class, 'DrupalCodeGenerator\TwigEnvironment');
}
