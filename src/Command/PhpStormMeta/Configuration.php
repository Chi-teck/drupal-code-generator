<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\Drupal\ConfigInfo;

/**
 * Generates PhpStorm meta-data for Drupal configuration.
 */
final class Configuration {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly ConfigInfo $configInfo,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    return File::create('.phpstorm.meta.php/configuration.php')
      ->template('configuration.php.twig')
      ->vars(['configs' => $this->configInfo->getConfigNames()]);
  }

}
