<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\Drupal\ServiceInfo;
use DrupalCodeGenerator\Utils;

/**
 * Generates PhpStorm meta-data for services.
 */
final class Services {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly ServiceInfo $serviceInfo,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    $services = [];
    $service_definitions = $this->serviceInfo->getServiceDefinitions();
    foreach ($service_definitions as $service_id => $service_definition) {
      if (isset($service_definition['class'])) {
        $services[$service_id] = Utils::addLeadingSlash($service_definition['class']);
      }
    }
    \ksort($services);

    return File::create('.phpstorm.meta.php/services.php')
      ->template('services.php.twig')
      ->vars(['services' => $services]);
  }

}
