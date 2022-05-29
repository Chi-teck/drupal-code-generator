#!/usr/bin/env php
<?php declare(strict_types=1);

/**
 * @file
 * Drupal CLI tool.
 *
 * Drush depends on specific version of DCG and therefore in some cases it
 * cannot be installed via Composer because of version conflict. This script
 * provides a very simple replacing for some common Drush commands.
 *
 * This script can only be executed from the Drupal root directory.
 */

use DrupalCodeGenerator\BootstrapHandler;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

$class_loader = require_once __DIR__ . '/autoload.php';

$container = (new BootstrapHandler($class_loader))->bootstrap();
$GLOBALS['module_installer'] = $container->get('module_installer');

function dcg_module_install(InputInterface $input): int {
  $module = $input->getArgument('module');
  return $GLOBALS['module_installer']->install([$module]) ? Command::SUCCESS : Command::FAILURE;
}

function dcg_module_uninstall(InputInterface $input): int {
  $module = $input->getArgument('module');
  return $GLOBALS['module_installer']->uninstall([$module]) ? Command::SUCCESS : Command::FAILURE;
}

(new Application('Drupal CLI'))

  ->register('module:install')
  ->addArgument('module', InputArgument::REQUIRED)
  ->setCode('dcg_module_install')
  ->getApplication()

  ->register('module:uninstall')
  ->addArgument('module', InputArgument::REQUIRED)
  ->setCode('dcg_module_uninstall')
  ->getApplication()

  ->register('cache:flush')
  ->setCode('drupal_flush_all_caches')
  ->getApplication()

  ->run();
