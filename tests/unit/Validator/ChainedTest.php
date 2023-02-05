<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\Chained;
use DrupalCodeGenerator\Validator\RegExp;
use PHPUnit\Framework\TestCase;

/**
 * Tests Chained validator.
 */
final class ChainedTest extends TestCase {

  /**
   * Test callback.
   *
   * @dataProvider dataProvider()
   */
  public function test(mixed $machine_name, ?\Exception $exception): void {
    if ($exception) {
      $this->expectExceptionObject($exception);
    }
    $validator = new Chained(
      new RegExp('/111/', 'v1'),
      new RegExp('/222/', 'v2'),
      new RegExp('/333/', 'v3'),
    );
    self::assertSame($machine_name, $validator($machine_name));
  }

  /**
   * Test callback.
   *
   * @dataProvider dataProvider()
   */
  public function testWith(mixed $machine_name, ?\Exception $exception): void {
    if ($exception) {
      $this->expectExceptionObject($exception);
    }
    $validator = new Chained(new RegExp('/111/', 'v1'));
    $validator = $validator->with(
      new RegExp('/222/', 'v2'),
      new RegExp('/333/', 'v3'),
    );
    self::assertSame($machine_name, $validator($machine_name));
  }

  /**
   * Test data provider.
   */
  public function dataProvider(): array {
    return [
      ['', new \UnexpectedValueException('v1')],
      ['111', new \UnexpectedValueException('v2')],
      ['111-222', new \UnexpectedValueException('v3')],
      ['111-222-333', NULL],
    ];
  }

}
