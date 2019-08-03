#!/usr/bin/env php
<?php

/**
 * @file
 * Generates hook templates from API documentation.
 */

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Dumps hooks.
 *
 * @param \Symfony\Component\Console\Input\InputInterface $input
 *   Input instance.
 * @param \Symfony\Component\Console\Output\OutputInterface $output
 *   Output instance.
 */
function dump_hooks(InputInterface $input, OutputInterface $output): void {

  $input_directory = $input->getArgument('input_directory');
  $output_directory = $input->getArgument('output_directory');

  check_directories($input_directory, $output_directory);

  $iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($input_directory, RecursiveDirectoryIterator::SKIP_DOTS)
  );

  $total = 0;
  foreach ($iterator as $path => $file) {
    $file_name = $file->getFileName();
    if (substr($file_name, -7) == 'api.php') {
      $output->writeln("<comment>$file_name</comment>");
      $hooks = parse_hooks($path);
      foreach ($hooks as $hook_name => $hook) {
        $output->writeln('  - ' . $hook_name);
        file_put_contents("$output_directory/$hook_name.twig", $hook);
        $total++;
      }
    }
  }

  $output->writeln('-----------------');
  $output->writeln('Dumped hooks: ' . $total);
}

/**
 * Checks if target directories exist.
 *
 * @param string $input_directory
 *   Directory to search for hooks.
 * @param string $output_directory
 *   Directory where hook templates should be dumped.
 *
 * @throws \Symfony\Component\Console\Exception\RuntimeException
 */
function check_directories(string $input_directory, string $output_directory): void {
  $file_system = new Filesystem();
  if (!$file_system->exists($input_directory)) {
    throw new RuntimeException('Input directory does not exist.');
  }
  if (!$file_system->exists($output_directory)) {
    throw new RuntimeException('Output directory does not exist.');
  }
}

/**
 * Extracts hooks from a singe PHP file.
 *
 * @param string $file
 *   File to parse.
 *
 * @return array
 *   Array of parsed hooks keyed by hook name.
 */
function parse_hooks(string $file) :array {
  $code = file_get_contents($file);

  preg_match_all("/function hook_(.*)\(.*\n\}\n/Us", $code, $matches);

  $results = [];
  foreach ($matches[0] as $index => $hook) {
    $hook_name = $matches[1][$index];
    $output = "/**\n * Implements hook_$hook_name().\n */\n";
    $output .= str_replace('function hook_', 'function {{ machine_name }}_', $hook);
    $results[$hook_name] = $output;
  }

  return $results;
}

(new Application('Hooks dumper'))
  ->register('dump-hooks')
  ->addArgument('input_directory', InputArgument::REQUIRED, 'Input directory')
  ->addArgument('output_directory', InputArgument::REQUIRED, 'Output directory')
  ->setCode('dump_hooks')
  ->getApplication()
  ->setDefaultCommand('dump-hooks', TRUE)
  ->run();
