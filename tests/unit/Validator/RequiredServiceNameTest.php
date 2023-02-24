<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\RequiredServiceName;
use PHPUnit\Framework\TestCase;

/**
 * Tests RequiredServiceName validator.
 */
final class RequiredServiceNameTest extends TestCase {

  /**
   * Test callback.
   *
   * @dataProvider dataProvider()
   */
  public function test(mixed $machine_name, ?\UnexpectedValueException $exception): void {
    if ($exception) {
      $this->expectExceptionObject($exception);
    }
    self::assertSame($machine_name, (new RequiredServiceName())($machine_name));
  }

  public function dataProvider(): array {
    $sn_exception = new \UnexpectedValueException('The value is not correct service name.');
    $rq_exception = new \UnexpectedValueException('The value is required.');
    return [
      ['snake_case_here', NULL],
      ['dot.inside', NULL],
      ['CamelCaseHere', $sn_exception],
      [' not_trimmed ', $sn_exception],
      ['0', $sn_exception],
      ['', $rq_exception],
      [NULL, $rq_exception],
      [FALSE, $sn_exception],
      [TRUE, $sn_exception],
    ];
  }

}
