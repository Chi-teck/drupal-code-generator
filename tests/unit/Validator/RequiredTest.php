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
  public function test(mixed $machine_name, ?string $expected): void {
    self::assertSame($expected, (new Required())($machine_name));
  }

  public static function dataProvider(): array {
    $error = 'The value is required.';
    return [
      ['yes', NULL],
      ['0', NULL],
      ['', $error],
      [NULL, $error],
      [FALSE, NULL],
      [TRUE, NULL],
      [[], $error],
      [['foo'], NULL],
    ];
  }

}
