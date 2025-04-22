<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use Drupal\Core\CronInterface;
use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;
use DrupalCodeGenerator\Asset\File;

/**
 * Generates PhpStorm meta-data for Drupal states.
 */
final class States {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly KeyValueFactoryInterface $keyValueStore,
    private readonly CronInterface $cron,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    $this->cron->run();
    $states = \array_keys($this->keyValueStore->get('state')->getAll());
    return File::create('.phpstorm.meta.php/states.php')
      ->template('states.php.twig')
      ->vars(['states' => $states]);
  }

}
