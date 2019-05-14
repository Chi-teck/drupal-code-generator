<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset;
use Symfony\Component\Console\Question\Question;

/**
 * Base class for module generators.
 */
abstract class ModuleGenerator extends DrupalGenerator {

  protected $nameQuestion = 'Module name';
  protected $machineNameQuestion = 'Module machine name';
  protected $extensionType = 'module';

  /**
   * Creates service file asset.
   *
   * @param string $path
   *   (Optional) File path.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  protected function addServicesFile(string $path = NULL) :Asset {
    return $this->addFile()
      ->path($path ?: '{machine_name}.services.yml')
      ->action('append')
      ->headerSize(1);
  }

  /**
   * Collects services.
   *
   * @return array
   *   List of collected services.
   */
  protected function collectServices(bool $default = TRUE) :array {

    if (!$this->confirm('Would you like to inject dependencies?', $default)) {
      return $this->vars['services'] = [];
    }

    $service_definitions = self::getServiceDefinitions();
    $service_ids = array_keys($service_definitions);

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
    foreach (array_unique($services) as $service_id) {
      if (isset($service_definitions[$service_id])) {
        $definition = $service_definitions[$service_id];
      }
      else {
        // Build the definition if the service is unknown.
        $definition = [
          'type' => 'Drupal\example\ExampleInterface',
          'name' => str_replace('.', '_', $service_id),
          'description' => "The $service_id service.",
        ];
      }
      $type_parts = explode('\\', $definition['type']);
      $definition['short_type'] = end($type_parts);
      $this->vars['services'][$service_id] = $definition;
    }
    return $this->vars['services'];
  }

  /**
   * Gets service definitions.
   *
   * @return array
   *   List of service definitions keyed by service ID.
   */
  protected static function getServiceDefinitions() :array {
    $data_encoded = file_get_contents(Application::getRoot() . '/resources/service-definitions.json');
    return json_decode($data_encoded, TRUE);
  }

}
