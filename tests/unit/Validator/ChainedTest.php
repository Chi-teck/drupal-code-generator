<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\Chained;
use DrupalCodeGenerator\Validator\RegExp;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests Chained validator.
 */
final class ChainedTest extends TestCase {

  /**
   * Test callback.
   */
  #[DataProvider('dataProvider')]
  public function test(mixed $machine_name, $expected): void {
    $validator = new Chained(
      new RegExp('/111/', 'v1'),
      new RegExp('/222/', 'v2'),
      new RegExp('/333/', 'v3'),
    );
    self::assertSame($expected, $validator($machine_name));
  }

  /**
   * Test callback.
   */
  #[DataProvider('dataProvider')]
  public function testWith(mixed $machine_name, $expected): void {
    $validator = new Chained(new RegExp('/111/', 'v1'));
    $validator = $validator->with(
      new RegExp('/222/', 'v2'),
      new RegExp('/333/', 'v3'),
    );
    self::assertSame($expected, $validator($machine_name));
  }

  /**
   * Test data provider.
   */
  public static function dataProvider(): array {
    return [
      ['', 'v1'],
      ['111', 'v2'],
      ['111-222', 'v3'],
      ['111-222-333', NULL],
    ];
  }

}
