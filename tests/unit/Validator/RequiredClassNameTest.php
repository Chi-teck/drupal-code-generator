<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\RequiredClassName;
use PHPUnit\Framework\TestCase;

/**
 * Tests RequiredClassName validator.
 */
final class RequiredClassNameTest extends TestCase {

  /**
   * Test callback.
   *
   * @dataProvider dataProvider()
   */
  public function test(mixed $machine_name, ?\Exception $exception): void {
    if ($exception) {
      $this->expectExceptionObject($exception);
    }
    self::assertSame($machine_name, (new RequiredClassName())($machine_name));
  }

  public function dataProvider(): array {
    $cn_exception = new \UnexpectedValueException('The value is not correct class name.');
    $rq_exception = new \UnexpectedValueException('The value is required.');
    return [
      ['Single', NULL],
      ['UpperCamelCase', NULL],
      ['snake_case_here', $cn_exception],
      ['With Space', $cn_exception],
      ['0', $cn_exception],
      ['', $rq_exception],
      [NULL, $rq_exception],
      [FALSE, $cn_exception],
      [TRUE, $cn_exception],
    ];
  }

}
