<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use Drupal\Core\Site\Settings as DrupalSettings;
use DrupalCodeGenerator\Asset\File;

/**
 * Generates PhpStorm meta-data for Drupal settings.
 */
final class Settings {

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    return File::create('.phpstorm.meta.php/settings.php')
      ->template('settings.php.twig')
      ->vars(['settings' => \array_keys(DrupalSettings::getAll())]);
  }

}
