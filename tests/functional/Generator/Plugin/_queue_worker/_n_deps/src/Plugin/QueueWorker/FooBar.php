<?php

declare(strict_types=1);

namespace Drupal\example\Plugin\QueueWorker;

use Drupal\Core\Queue\Attribute\QueueWorker;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines 'example_foo_bar' queue worker.
 */
#[QueueWorker(
  id: 'example_foo_bar',
  title: new TranslatableMarkup('Test'),
  cron: ['time' => 60],
)]
final class FooBar extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($data): void {
    // @todo Process data here.
  }

}
