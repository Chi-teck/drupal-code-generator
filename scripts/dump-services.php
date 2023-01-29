#!/usr/bin/env php
<?php declare(strict_types = 1);

/**
 * @file
 * Service definition dumper.
 *
 * Before running this script make sure that all core modules are installed on
 * target Drupal installation.
 *
 * @todo Dump services for core modules.
 */

use Drupal\Core\DrupalKernel;
use DrupalCodeGenerator\Utils;
use Symfony\Component\HttpFoundation\Request;

$start = \microtime(TRUE);

if (empty($argv[1])) {
  \fwrite(\STDERR, "Usage: {$argv[0]} path/to/drupal\n");
  exit(1);
}

$autoload = $argv[1] . '/autoload.php';
if (!file_exists($autoload)) {
  \fwrite(\STDERR, "$autoload does not exist\n");
  exit(1);
}

// STEP 1. Bootstrap Drupal.
\chdir($argv[1]);
$autoloader = require_once $autoload;
$request = Request::createFromGlobals();
$kernel = new DrupalKernel('prod', $autoloader);
$kernel->handle($request);

// Override Drupal exception handler.
\set_exception_handler(static function (\Throwable $exception): void {
  \fwrite(\STDERR, $exception->getMessage() . "\n");
  \exit(1);
});
\restore_error_handler();

// STEP 2. Load and process available service definitions.
$cache_definitions = \Drupal::getContainer()
  ->get('kernel')
  ->getCachedContainerDefinition();

$definitions = [];
foreach ($cache_definitions['aliases'] as $type_fqn => $service_id) {
  $type_parts = \explode('\\', $type_fqn);
  $type = \end($type_parts);

  // Override names for some services.
  $name = match($service_id) {
    'database' => 'connection',
    'current_route_match' => 'routeMatch',
    'logger.log_message_parser' => 'parser',
    default => Utils::camelize($service_id, FALSE)
  };

  $definitions[$service_id] = [
    'type_fqn' => $type_fqn,
    'type' => $type,
    'name' => $name,
  ];
}
\ksort($definitions);

// STEP 3. Dump definitions.
$encoded_data = json_encode($definitions);
$size = \file_put_contents(__DIR__ . '/../resources/service-meta.json', $encoded_data);
if ($size === FALSE) {
  \fwrite(STDERR, "Could not save data to a file.\n");
  exit(1);
}

$finish = \microtime(TRUE);

// STEP 4. Print summary.
\printf(
  <<< 'TXT'
  --------------------------
   Definitions    %d
   File size:     %s
   Time:          %d ms
  --------------------------
  
  TXT,
  \count($definitions),
  \format_size($size),
  \round(1000 * ($finish - $start)),
);
