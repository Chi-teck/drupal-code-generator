<?php

/**
 * @file
 * Globals.
 */

use DrupalCodeGenerator\ApplicationFactory;

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

// Determine major Twig version.
// Twig_Environment::MAJOR_VERSION is not suitable here because of
// https://github.com/twigphp/Twig/pull/2945
// Use this workaround as drupal/drupal is locked on Twig 1.38.
list($twig_major_version) = sscanf(Twig_Environment::VERSION, '%d.%d.%d');

// Twig_Environment::tokenize() signature has been changed in Twig 2, so that
// it is not possible to maintain the same Twig_Environment sub-class for both
// Twig versions.
$twig_environment_class = sprintf('DrupalCodeGenerator\Twig\Twig%dEnvironment', $twig_major_version);
class_alias($twig_environment_class, 'DrupalCodeGenerator\Twig\TwigEnvironment');

// Legacy TwigEnvironment class is still used in Drush.
class_alias($twig_environment_class, 'DrupalCodeGenerator\TwigEnvironment');
