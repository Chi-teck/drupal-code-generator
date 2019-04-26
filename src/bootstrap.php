<?php

/**
 * @file
 * Globals.
 */

use DrupalCodeGenerator\ApplicationFactory;
use Symfony\Component\Console\Application;

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
function dcg_create_application() :Application {
  return ApplicationFactory::create();
}
