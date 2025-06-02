<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\MachineName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests MachineName validator.
 */
final class MachineNameTest extends TestCase {

  /**
   * Test callback.
   */
  #[DataProvider('dataProvider')]
  public function test(mixed $machine_name, ?string $expected): void {
    self::assertSame($expected, (new MachineName())($machine_name));
  }

  public static function dataProvider(): array {
    $error = 'The value is not correct machine name.';
    return [
      ['snake_case_here', NULL],
      ['ends_with_number123', NULL],
      ['UPPER_CASE', $error],
      ['123begins_with_number', $error],
      ['with.dot', $error],
      [' not_trimmed ', $error],
      ['Hello world ', $error],
      ['ends_with_underscore_', $error],
      ['', $error],
      ['foo*&)(*&@#()*&@#bar', $error],
      [TRUE, $error],
      [NULL, $error],
      [[], $error],
      [new \stdClass(), $error],
    ];
  }

}
