<?php

/**
 * @file
 * Globals.
 */

use DrupalCodeGenerator\OutputDumper;
use Symfony\Component\Console\Application;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Dumper;

define('DCG_ROOT', dirname(__DIR__));
define('DCG_HOME', $_SERVER['HOME'] . '/.dcg');
define('DCG_SANDBOX', DCG_ROOT . '/sandbox');

/**
 * Creates an application.
 */
function dcg_create_application() {
  $application = new Application('Drupal Code Generator', '@git-version@');
  $output_dumper = new OutputDumper(new Filesystem(), new Dumper());
  $application->getHelperSet()->set($output_dumper);
  return $application;
}
