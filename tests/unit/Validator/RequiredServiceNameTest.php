<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\RequiredServiceName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests RequiredServiceName validator.
 */
final class RequiredServiceNameTest extends TestCase {

  /**
   * Test callback.
   */
  #[DataProvider('dataProvider')]
  public function test(mixed $machine_name, $expected): void {
    self::assertSame($expected, (new RequiredServiceName())($machine_name));
  }

  public static function dataProvider(): array {
    $sn_error = 'The value is not correct service name.';
    $rq_error = 'The value is required.';
    return [
      ['snake_case_here', NULL],
      ['dot.inside', NULL],
      ['CamelCaseHere', $sn_error],
      [' not_trimmed ', $sn_error],
      ['0', $sn_error],
      ['', $rq_error],
      [NULL, $rq_error],
      [FALSE, $sn_error],
      [TRUE, $sn_error],
    ];
  }

}
