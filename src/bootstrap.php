<?php

/**
 * @file
 * Globals.
 */

use DrupalCodeGenerator\Helper\Dumper;
use DrupalCodeGenerator\Helper\InputHandler;
use DrupalCodeGenerator\Helper\OutputHandler;
use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\TwigEnvironment;
use Symfony\Component\Console\Application;
use Symfony\Component\Filesystem\Filesystem;

define('DCG_ROOT', dirname(__DIR__));

/**
 * Creates an application.
 *
 * @return \Symfony\Component\Console\Application
 *   The initialized console application.
 */
function dcg_create_application() {
  $application = new Application('Drupal Code Generator', '@git-version@');
  $helperSet = $application->getHelperSet();

  $dumper = new Dumper(new Filesystem());
  $helperSet->set($dumper);

  $twig_loader = new Twig_Loader_Filesystem();
  $renderer = new Renderer(new TwigEnvironment($twig_loader));
  $helperSet->set($renderer);

  $helperSet->set(new InputHandler());

  $helperSet->set(new OutputHandler());

  return $application;
}
