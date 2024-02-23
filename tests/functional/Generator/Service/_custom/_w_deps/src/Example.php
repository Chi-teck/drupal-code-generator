<?php

declare(strict_types=1);

namespace Drupal\foo;

use Drupal\Core\Cache\CacheTagsInvalidatorInterface;
use Drupal\Core\CronInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * @todo Add class description.
 */
final class Example {

  /**
   * Constructs an Example object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly CronInterface $cron,
    private readonly CacheTagsInvalidatorInterface $cacheTagsInvalidator,
  ) {}

  /**
   * @todo Add method description.
   */
  public function doSomething(): void {
    // @todo Place your code here.
  }

}
