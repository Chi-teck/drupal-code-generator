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

// Twig_Environment::tokenize() signature has been changed in Twig 2, so that
// it is not possible to maintain the same Twig_Environment sub-class for both
// Twig versions.
$twig_environment_class = sprintf('DrupalCodeGenerator\Twig\Twig%dEnvironment', Twig_Environment::MAJOR_VERSION);
class_alias($twig_environment_class, 'DrupalCodeGenerator\Twig\TwigEnvironment');
