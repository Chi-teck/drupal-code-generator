<?php

declare(strict_types=1);

namespace Drupal\example;

use Drupal\Core\Batch\BatchBuilder;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Service for batch processing.
 */
final class ExampleBatch {
  use StringTranslationTrait;

  /**
   * Builds a batch.
   *
   * @param array $items
   *   The items to process.
   *
   * @return array
   *   The batch definition.
   */
  public function buildBatch(array $items) {
    $batch_builder = new BatchBuilder();
    $batch_builder
      ->setTitle($this->t('Processing items...'))
      ->setFinishCallback([$this, 'finished']);

    foreach ($items as $item) {
      $batch_builder->addOperation([$this, 'processItem'], [$item]);
    }

    return $batch_builder->toArray();
  }

  /**
   * Processes a single batch item.
   *
   * @param mixed $item
   *   The item to process.
   * @param array $context
   *   The batch context.
   */
  public function processItem($item, array &$context) {
    // @todo Implement batch processing logic.
  }

  /**
   * Batch finish callback.
   *
   * @param bool $success
   *   Indicates whether the batch process was successful.
   * @param array $results
   *   The results from the batch process.
   * @param array $operations
   *   The operations that were processed.
   */
  public function finished(bool $success, array $results, array $operations) {
    if ($success) {
      // @todo Implement batch processing logic.
    }
    else {
      // @todo Implement batch processing logic.
    }
  }

}
