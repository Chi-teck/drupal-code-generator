<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\MachineName;
use PHPUnit\Framework\TestCase;

/**
 * Tests MachineName validator.
 */
final class MachineNameTest extends TestCase {

  /**
   * Test callback.
   *
   * @dataProvider dataProvider()
   */
  public function test(mixed $machine_name, ?\Exception $exception): void {
    if ($exception) {
      $this->expectExceptionObject($exception);
    }
    self::assertSame($machine_name, (new MachineName())($machine_name));
  }

  public function dataProvider(): array {
    $exception = new \UnexpectedValueException('The value is not correct machine name.');
    return [
      ['snake_case_here', NULL],
      ['ends_with_number123', NULL],
      ['UPPER_CASE', $exception],
      ['123begins_with_number', $exception],
      ['with.dot', $exception],
      [' not_trimmed ', $exception],
      ['Hello world ', $exception],
      ['ends_with_underscore_', $exception],
      ['', $exception],
      ['foo*&)(*&@#()*&@#bar', $exception],
      [TRUE, $exception],
      [NULL, $exception],
      [[], $exception],
      [new \stdClass(), $exception],
    ];
  }

}
