<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\Required;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests Required validator.
 */
final class RequiredTest extends TestCase {

  /**
   * Test callback.
   */
  #[DataProvider('dataProvider')]
  public function test(mixed $machine_name, ?\UnexpectedValueException $exception): void {
    if ($exception) {
      $this->expectExceptionObject($exception);
    }
    self::assertSame($machine_name, (new Required())($machine_name));
  }

  public static function dataProvider(): array {
    $exception = new \UnexpectedValueException('The value is required.');
    return [
      ['yes', NULL],
      ['0', NULL],
      ['', $exception],
      [NULL, $exception],
      [FALSE, NULL],
      [TRUE, NULL],
      [[], $exception],
      [['foo'], NULL],
    ];
  }

}
