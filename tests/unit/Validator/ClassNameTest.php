<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\ClassName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests ClassName validator.
 */
final class ClassNameTest extends TestCase {

  /**
   * Test callback.
   */
  #[DataProvider('dataProvider')]
  public function test(mixed $machine_name, $expected): void {
    self::assertSame($expected, (new ClassName())($machine_name));
  }

  public static function dataProvider(): array {
    $error = 'The value is not correct class name.';
    return [
      ['Single', NULL],
      ['UpperCamelCase', NULL],
      ['lowCamelCase', $error],
      ['snake_case_here', $error],
      ['With Space', $error],
      [' NotTrimmed ', $error],
      ['With_Underscore', $error],
      ['WrongSymbols@)@#&)', $error],
      [TRUE, $error],
      [NULL, $error],
      [[], $error],
      [new \stdClass(), $error],
    ];
  }

}
