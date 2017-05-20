<?php

/**
 * @file
 * Globals.
 */

use DrupalCodeGenerator\InputHandler;
use DrupalCodeGenerator\OutputDumper;
use DrupalCodeGenerator\OutputHandler;
use DrupalCodeGenerator\Renderer;
use DrupalCodeGenerator\TwigEnvironment;
use Symfony\Component\Console\Application;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Dumper;

define('DCG_ROOT', dirname(__DIR__));
define('DCG_HOME', $_SERVER['HOME'] . '/.dcg');
define('DCG_SANDBOX', DCG_ROOT . '/sandbox');

/**
 * Creates an application.
 */
function dcg_create_application(array $twig_directories) {
  $application = new Application('Drupal Code Generator', '@git-version@');
  $helperSet = $application->getHelperSet();

  $output_dumper = new OutputDumper(new Filesystem(), new Dumper());
  $helperSet->set($output_dumper);

  $twig_loader = new Twig_Loader_Filesystem($twig_directories);
  $renderer = new Renderer(new TwigEnvironment($twig_loader));
  $helperSet->set($renderer);

  $helperSet->set(new InputHandler());

  $helperSet->set(new OutputHandler());

  return $application;
}
