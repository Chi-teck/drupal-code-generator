<?php

namespace Drupal\foo;

use Drupal\Core\Cache\CacheTagsInvalidatorInterface;
use Drupal\Core\CronInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Example service.
 */
class Example {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The cron service.
   *
   * @var \Drupal\Core\CronInterface
   */
  protected $cron;

  /**
   * The cache tags invalidator.
   *
   * @var \Drupal\Core\Cache\CacheTagsInvalidatorInterface
   */
  protected $cacheTagsInvalidator;

  /**
   * Constructs an example object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\CronInterface $cron
   *   The cron service.
   * @param \Drupal\Core\Cache\CacheTagsInvalidatorInterface $cache_tags_invalidator
   *   The cache tags invalidator.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, CronInterface $cron, CacheTagsInvalidatorInterface $cache_tags_invalidator) {
    $this->entityTypeManager = $entity_type_manager;
    $this->cron = $cron;
    $this->cacheTagsInvalidator = $cache_tags_invalidator;
  }

  /**
   * Method description.
   */
  public function doSomething() {
    // @DCG place your code here.
  }

}
