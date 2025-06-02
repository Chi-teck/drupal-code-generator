<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\RegExp;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests RegExp validator.
 */
final class RegExpTest extends TestCase {

  /**
   * Test callback.
   */
  #[DataProvider('dataProvider')]
  public function test(mixed $machine_name, string $pattern, ?string $message, $expected): void {
    $validator = new RegExp($pattern, $message);
    self::assertSame($expected, $validator($machine_name));
  }

  public static function dataProvider(): array {
    return [
      ['wrong', '/abc/', NULL, 'The value does not match pattern "/abc/".'],
      ['wrong', '/abc/', 'Custom message', 'Custom message'],
      ['abc', '/abc/', NULL, NULL],
      [NULL, '/abc/', NULL, 'The value does not match pattern "/abc/".'],
      [FALSE, '/abc/', NULL, 'The value does not match pattern "/abc/".'],
      [[], '/abc/', NULL, 'The value does not match pattern "/abc/".'],
    ];
  }

}
