<?php

namespace Drupal\example\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;

/**
 * Defines 'example_foo_bar' queue worker.
 *
 * @QueueWorker(
 *   id = "example_foo_bar",
 *   title = @Translation("Test"),
 *   cron = {"time" = 60}
 * )
 */
class FooBar extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    // @todo Process data here.
  }

}
