<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Asset;
use Symfony\Component\Console\Question\Question;

/**
 * Base class for module generators.
 */
abstract class ModuleGenerator extends DrupalGenerator {

  protected $nameQuestion = 'Module name';
  protected $machineNameQuestion = 'Module machine name';
  protected $extensionType = self::EXTENSION_TYPE_MODULE;

  /**
   * Adds an asset for service file.
   *
   * @param string $path
   *   (Optional) File path.
   *
   * @return \DrupalCodeGenerator\Asset\File
   *   The asset.
   */
  protected function addServicesFile(string $path = '{machine_name}.services.yml'): Asset {
    return $this->addFile($path)
      ->appendIfExists()
      ->headerSize(1);
  }

  /**
   * Adds an asset for configuration schema file.
   *
   * @param string $path
   *   (Optional) File path.
   *
   * @return \DrupalCodeGenerator\Asset\File
   *   The asset.
   */
  protected function addSchemaFile(string $path = 'config/schema/{machine_name}.schema.yml'): Asset {
    return $this->addFile($path)
      ->appendIfExists();
  }

  /**
   * Collects services.
   *
   * @param bool $default
   *   (Optional) Default value for the confirmation question.
   *
   * @return array
   *   List of collected services.
   */
  protected function collectServices(bool $default = TRUE): array {

    if (!$this->confirm('Would you like to inject dependencies?', $default)) {
      return $this->vars['services'] = [];
    }

    $service_ids = $this->getServiceIds();

    $services = [];
    while (TRUE) {
      $question = new Question('Type the service name or use arrows up/down. Press enter to continue');
      $question->setValidator([__CLASS__, 'validateServiceName']);
      $question->setAutocompleterValues($service_ids);
      $service = $this->io()->askQuestion($question);
      if (!$service) {
        break;
      }
      $services[] = $service;
    }

    $this->vars['services'] = [];
    foreach (\array_unique($services) as $service_id) {
      $this->vars['services'][$service_id] = $this->getServiceDefinition($service_id);
    }
    return $this->vars['services'];
  }

  /**
   * Gets service definitions.
   *
   * @return array
   *   List of service IDs.
   */
  protected function getServiceIds(): array {
    if ($this->drupalContext) {
      $data = $this->drupalContext->getServicesIds();
    }
    else {
      $service_definitions = self::getDumpedServiceDefinitions();
      $data = \array_keys($service_definitions);
    }
    return $data;
  }

  /**
   * Gets service definitions.
   *
   * @param string $service_id
   *   The service ID.
   *
   * @return array
   *   Service definition or null if service is unknown.
   */
  protected function getServiceDefinition(string $service_id): array {
    $service_definitions = self::getDumpedServiceDefinitions();
    if (isset($service_definitions[$service_id])) {
      $definition = $service_definitions[$service_id];
    }
    else {
      // Make up service definition.
      $name_parts = \explode('.', $service_id);
      $definition = [
        'name' => \end($name_parts),
        'type' => 'Drupal\example\ExampleInterface',
        'description' => "The $service_id service.",
      ];

      if ($this->drupalContext) {
        // Try to guess correct type of service instance.
        $compiled_definition = $this->drupalContext->getServiceDefinition($service_id);
        if ($compiled_definition && isset($compiled_definition['class'])) {
          $interface = $compiled_definition['class'] . 'Interface';
          $definition['type'] = \interface_exists($interface) ? $interface : $compiled_definition['class'];
        }
      }
    }

    $type_parts = \explode('\\', $definition['type']);
    $definition['short_type'] = \end($type_parts);

    return $definition;
  }

  /**
   * Gets service definitions.
   *
   * @return array
   *   List of service definitions keyed by service ID.
   */
  private static function getDumpedServiceDefinitions(): array {
    $data_encoded = \file_get_contents(Application::ROOT . '/resources/service-definitions.json');
    return \json_decode($data_encoded, TRUE);
  }

}
