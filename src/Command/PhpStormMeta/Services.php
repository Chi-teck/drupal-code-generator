<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\Drupal\ServiceInfo;

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
    return File::create('.phpstorm.meta.php/services.php')
      ->template('services.php.twig')
      ->vars(['services' => $this->serviceInfo->getServiceClasses()]);
  }

}
