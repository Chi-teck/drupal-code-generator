<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use DrupalCodeGenerator\Asset\File;

/**
 * Generates PhpStorm meta-data for date formats.
 */
final class DateFormats {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    $date_formats = $this->entityTypeManager
      ->getStorage('date_format')
      ->loadMultiple();
    $date_formats['custom'] = NULL;
    return File::create('.phpstorm.meta.php/date_formats.php')
      ->template('date_formats.php.twig')
      ->vars(['date_formats' => \array_keys($date_formats)]);
  }

}
