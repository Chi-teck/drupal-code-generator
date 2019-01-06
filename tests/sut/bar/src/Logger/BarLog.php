<?php

namespace Drupal\bar\Logger;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\dblog\Logger\DbLog;

/**
 * Logs events in the watchdog database table.
 */
class BarLog extends DbLog {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function log($level, $message, array $context = []) {
    \Drupal::messenger()->addStatus($this->t('Bar logger is active.'));
    parent::log($level, $message, $context);
  }

}
