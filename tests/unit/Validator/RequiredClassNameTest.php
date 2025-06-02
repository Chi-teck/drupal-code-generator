<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\RequiredClassName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests RequiredClassName validator.
 */
final class RequiredClassNameTest extends TestCase {

  /**
   * Test callback.
   */
  #[DataProvider('dataProvider')]
  public function test(mixed $machine_name, $expected): void {
    self::assertSame($expected, (new RequiredClassName())($machine_name));
  }

  public static function dataProvider(): array {
    $cn_error = 'The value is not correct class name.';
    $rq_error = 'The value is required.';
    return [
      ['Single', NULL],
      ['UpperCamelCase', NULL],
      ['snake_case_here', $cn_error],
      ['With Space', $cn_error],
      ['0', $cn_error],
      ['', $rq_error],
      [NULL, $rq_error],
      [FALSE, $cn_error],
      [TRUE, $cn_error],
    ];
  }

}
