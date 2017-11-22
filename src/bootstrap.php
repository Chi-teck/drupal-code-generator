<?php

/**
 * @file
 * Globals.
 */

use DrupalCodeGenerator\Helper\Dumper;
use DrupalCodeGenerator\Helper\InputHandler;
use DrupalCodeGenerator\Helper\OutputHandler;
use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\Twig\TwigEnvironment;
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
  // This gets substituted with git version when DCG is packaged to PHAR file.
  $version = '@git-version@';

  // Fallback for composer installation.
  if (!is_numeric($version[0])) {
    $version = 'UNKNOWN';
  }

  $application = new Application('Drupal Code Generator', $version);
  $helper_set = $application->getHelperSet();

  $dumper = new Dumper(new Filesystem());
  $helper_set->set($dumper);

  $twig_loader = new Twig_Loader_Filesystem();
  $renderer = new Renderer(new TwigEnvironment($twig_loader));
  $helper_set->set($renderer);

  $helper_set->set(new InputHandler());

  $helper_set->set(new OutputHandler());

  return $application;
}
