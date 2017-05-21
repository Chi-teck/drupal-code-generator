<?php

/**
 * @file
 * Globals.
 */

use DrupalCodeGenerator\Helpers\Dumper;
use DrupalCodeGenerator\Helpers\InputHandler;
use DrupalCodeGenerator\Helpers\OutputHandler;
use DrupalCodeGenerator\Helpers\Renderer;
use DrupalCodeGenerator\TwigEnvironment;
use Symfony\Component\Console\Application;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Dumper as YamlDumper;

define('DCG_ROOT', dirname(__DIR__));
define('DCG_HOME', $_SERVER['HOME'] . '/.dcg');
define('DCG_SANDBOX', DCG_ROOT . '/sandbox');

/**
 * Creates an application.
 *
 * @return \Symfony\Component\Console\Application
 *   The initialized console application.
 */
function dcg_create_application() {
  $application = new Application('Drupal Code Generator', '@git-version@');
  $helperSet = $application->getHelperSet();

  $dumper = new Dumper(new Filesystem(), new YamlDumper());
  $helperSet->set($dumper);

  $twig_loader = new Twig_Loader_Filesystem();
  $renderer = new Renderer(new TwigEnvironment($twig_loader));
  $helperSet->set($renderer);

  $helperSet->set(new InputHandler());

  $helperSet->set(new OutputHandler());

  return $application;
}
