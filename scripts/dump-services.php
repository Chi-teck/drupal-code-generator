#!/usr/bin/env php
<?php

/**
 * @file
 * Service definition dumper.
 *
 * Before running this script make sure that all core modules are installed on
 * target Drupal installation.
 */

use Drupal\Core\DrupalKernel;
use Symfony\Component\HttpFoundation\Request;

$start = microtime(TRUE);

if (empty($argv[1])) {
  fwrite(STDERR, "Usage: {$argv[0]} path/to/drupal\n");
  exit(1);
}

$autoload = $argv[1] . '/autoload.php';
if (!file_exists($autoload)) {
  fwrite(STDERR, "$autoload does not exist\n");
  exit(1);
}

// STEP 1. Bootstrap Drupal.
chdir($argv[1]);
$autoloader = require_once $autoload;
$kernel = new DrupalKernel('prod', $autoloader);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);

// Override Drupal exception handler.
set_exception_handler(static function (\Exception $exception): void {
  fwrite(STDERR, $exception->getMessage() . "\n");
  exit(1);
});
restore_error_handler();

// STEP 2. Load and process available service definitions.
$services = \Drupal::getContainer()
  ->get('kernel')
  ->getCachedContainerDefinition()['services'];
$services = array_map('unserialize', $services);

// A storage for raw service definitions.
$raw_definitions = [];

$skipped_services = [
  // This has unused argument in its definition.
  'book.export',
  // This is a synthetic service.
  'class_loader',
  // This defines wrong parameter type in its annotation.
  'config_snapshot_subscriber',
  // This has unused argument in its definition.
  'context.handler',
  // This has unused arguments in its definition.
  'drupal.proxy_original_service.module_installer',
  // This has unused argument in its definition.
  'forum.index_storage',
  // This has unused argument in its definition.
  'maintenance_mode',
  // This has unused arguments in its definition.
  'module_installer',
  // This annotates parameter type in a short form.
  'router.matcher',
  // This does not define type hint for $options parameter.
  'session_configuration',
  // This does not define type for 'session_handler' argument.
  'session_manager',
  // This has unused arguments in its definition.
  'toolbar.menu_tree',
  // This does not define type hint for $options parameter.
  'twig',
  // These are not objects.
  'app.root',
  'site.path',
  'update.root',
];

foreach ($services as $service_id => $service) {

  if (strpos($service_id, 'drush') !== FALSE) {
    throw new UnexpectedValueException('Drush services are not supported.');
  }

  if (in_array($service_id, $skipped_services)) {
    continue;
  }

  $dependencies = [];
  if (isset($service['arguments'], $service['arguments']->type) && $service['arguments']->type == 'collection') {
    foreach ($service['arguments']->value as $argument) {
      if (isset($argument->type) && $argument->type == 'service') {
        $dependencies[] = $argument->id;
      }
      else {
        // This will preserve correct positions for other dependencies.
        $dependencies[] = NULL;
      }
    }
  }

  process_class($raw_definitions, $service_id, $service['class'], $dependencies);
}

// STEP 3. Normalize definitions and dump them to a file.
$definitions = [];
foreach ($raw_definitions as $service_id => $raw_definition) {

  if (isset($raw_definition['references'])) {

    // The following services are referenced with a different types.
    $multi_type_services = [
      'controller_resolver',
      'current_user',
      'keyvalue.expirable',
      'language_manager',
      'path_processor_manager',
      'plugin.manager.display_variant',
      'request_stack',
      'router',
      'router.no_access_checks',
      'router.route_provider',
      'url_generator',
    ];
    $unique_types = array_unique($raw_definition['references']['real']['type']);
    if (count($unique_types) != 1 && !in_array($service_id, $multi_type_services)) {
      throw new UnexpectedValueException("The $service_id service has more than one type.");
    }

    // Pick up the most used type.
    $types = array_count_values($raw_definition['references']['real']['type']);
    arsort($types);
    $type = key($types);

    // Pick up the most used name.
    $names = array_count_values($raw_definition['references']['real']['name']);
    arsort($names);
    $name = key($names);

    // Pick up the most used description.
    $descriptions = array_count_values($raw_definition['references']['annotation']['description']);
    arsort($descriptions);
    // The description in annotation it may not exist.
    $description = key($descriptions) ?: "The $service_id service.";

    $definitions[$service_id] = [
      'type' => $type,
      'name' => $name,
      'description' => $description,
    ];
  }

  if (empty($definitions[$service_id]['type'])) {
    if (isset($raw_definition['type'][0])) {
      $type = $raw_definition['type'][0];
    }
    elseif (in_array($service_id, $skipped_services)) {
      // Skipped services might get to the definitions through references.
      unset($definitions[$service_id]);
      continue;
    }
    else {
      throw new UnexpectedValueException("No type declared for service $service_id.");
    }
    $definitions[$service_id] = [
      'type' => $type,
      'name' => str_replace('.', '_', $service_id),
      'description' => "The $service_id service.",
    ];
  }

}

ksort($definitions);
$encoded_data = json_encode($definitions);
$size = file_put_contents(__DIR__ . '/../resources/service-definitions.json', $encoded_data);
if ($size === FALSE) {
  fwrite(STDERR, "Could not save data to a file.\n");
  exit(1);
}

$finish = microtime(TRUE);

print "-----------------------\n";
printf("Services: %s\n", count($services));
printf("Raw definitions: %s\n", count($raw_definitions));
printf("Normalized definitions: %s\n", count($definitions));
printf("File size: %s\n", format_size($size));
printf("Time: %s ms\n", round(1000 * ($finish - $start)));
print "-----------------------\n";

/**
 * Processes service class.
 *
 * @param array $raw_definitions
 *   A storage for raw definitions.
 * @param string $service_id
 *   Service ID.
 * @param string $class
 *   Service class.
 * @param array $dependencies
 *   Service dependencies.
 *
 * @throws \UnexpectedValueException
 */
function process_class(array &$raw_definitions, string $service_id, string $class, array $dependencies): void {

  if (!class_exists($class) && !interface_exists($class)) {
    throw new UnexpectedValueException("The service class $class does not exit.");
  }

  $reflection_class = new ReflectionClass($class);
  $raw_definitions[$service_id]['type'] = $reflection_class->getInterfaceNames();
  $raw_definitions[$service_id]['type'][] = $class;

  if (count($dependencies) && !$reflection_class->hasMethod('__construct')) {
    throw new UnexpectedValueException("The service class $class does not have a constructor.");
  }

  // -- Process service dependencies.
  if (!$dependencies) {
    return;
  }

  // Symfony annotations are not properly formatted.
  if (strpos($class, 'Symfony') === 0) {
    return;
  }

  $reflection_constructor = $reflection_class->getMethod('__construct');

  // Parse constructor annotation.
  $doc = $reflection_constructor->getDocComment();
  preg_match_all('/@param (.*) \$(.*)\n\s*\*\s\s\s([^s].*)\n/Us', $doc, $annotations);

  $parameters = $reflection_constructor->getParameters();
  foreach ($dependencies as $position => $dependency_id) {

    // The dependency ID is empty when the dependency is not a service.
    if ($dependency_id === NULL) {
      continue;
    }

    $parameter = $parameters[$position];
    if (!$parameter) {
      $message = sprintf('Could not find a parameter at position %d in %s class.', $position, $class);
      throw new UnexpectedValueException($message);
    }

    // The annotation for the parameter was missing or incorrect.
    if (!isset($annotations[1][$position])) {
      continue;
    }
    $annotated_type = ltrim($annotations[1][$position], '\\');
    // Normalize array type.
    if ($annotated_type == 'array' || preg_match('/.+\[\]$/', $annotated_type)) {
      $annotated_type = '\\array';
    }
    $annotated_name = $annotations[2][$position];
    $annotated_description = $annotations[3][$position];
    $type = $parameter->getType();
    $real_type = $type ? $type->getName() : '';
    $real_name = $parameter->getName();

    // Do some basic validation.
    $annotated_type = str_replace('|null', '', $annotated_type);
    $scalar_types = ['string', 'bool', 'int'];
    if ($annotated_type && !in_array($annotated_type, $scalar_types) && !preg_match('/\|/', $annotated_type)) {
      if ($annotated_type != $real_type) {
        $message = sprintf(
          "Annotated type '%s' does match the real type '%s' in '%s' service'.",
          $annotated_type,
          $real_type,
          $service_id
        );
        throw new UnexpectedValueException($message);
      }
    }

    if ($annotated_name && $annotated_name != $real_name) {
      $message = sprintf(
        "Annotated name '%s' does match the real name '%s' in '%s' service'.",
        $annotated_name,
        $real_name,
        $service_id
      );
      throw new UnexpectedValueException($message);
    }

    $raw_definitions[$dependency_id]['references']['annotation']['type'][] = $annotated_type;
    $raw_definitions[$dependency_id]['references']['annotation']['name'][] = $annotated_name;
    $raw_definitions[$dependency_id]['references']['annotation']['description'][] = $annotated_description;
    $raw_definitions[$dependency_id]['references']['real']['type'][] = $real_type;
    $raw_definitions[$dependency_id]['references']['real']['name'][] = $real_name;
  }

}
