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
