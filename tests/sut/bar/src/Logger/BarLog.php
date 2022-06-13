<?php

namespace Drupal\bar\Logger;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\dblog\Logger\DbLog;

/**
 * Logs events in the watchdog database table.
 */
final class BarLog extends DbLog {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function log($level, string|\Stringable $message, array $context = []): void {
    \Drupal::messenger()->addStatus($this->t('Bar logger is active.'));
    parent::log($level, $message, $context);
  }

}
