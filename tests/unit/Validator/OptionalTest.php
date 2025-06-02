<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\MachineName;
use DrupalCodeGenerator\Validator\Optional;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests Optional validator.
 */
final class OptionalTest extends TestCase {

  /**
   * Test callback.
   */
  #[DataProvider('dataProvider')]
  public function test(mixed $machine_name, ?string $expected): void {
    $validator = new Optional(new MachineName());
    self::assertSame($expected, $validator($machine_name));
  }

  public static function dataProvider(): array {
    $error = 'The value is not correct machine name.';
    return [
      ['foo*&)(*&@#()*&@#bar', $error],
      [TRUE, $error],
      [NULL, NULL],
      ['', NULL],
      [' ', $error],
      [new \stdClass(), $error],
    ];
  }

}
