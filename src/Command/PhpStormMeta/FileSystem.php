<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use DrupalCodeGenerator\Asset\File;

/**
 * Generates PhpStorm meta-data for Drupal filesystem helpers.
 */
final class FileSystem {

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    return File::create('.phpstorm.meta.php/file_system.php')
      ->template('file_system.php.twig');
  }

}
