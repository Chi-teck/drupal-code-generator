<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit;

use Psr\Log\AbstractLogger;

/**
 * Test logger.
 *
 * @todo Is it still used?
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
