<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests;

use Psr\Log\AbstractLogger;

/**
 * Test logger.
 */
final class TestLogger extends AbstractLogger {

  public array $records = [];

  /**
   * {@inheritdoc}
   */
  public function log($level, $message, array $context = []): void {
    $this->records[] = [
      'level' => $level,
      'message' => $message,
      'context' => $context,
    ];
  }

}
