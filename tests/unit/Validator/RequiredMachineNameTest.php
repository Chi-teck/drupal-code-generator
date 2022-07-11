<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\RequiredMachineName;
use PHPUnit\Framework\TestCase;

/**
 * Tests RequiredMachineName validator.
 */
final class RequiredMachineNameTest extends TestCase {

  /**
   * Test callback.
   *
   * @dataProvider dataProvider()
   */
  public function test(mixed $machine_name, ?\Exception $exception): void {
    if ($exception) {
      $this->expectExceptionObject($exception);
    }
    self::assertSame($machine_name, (new RequiredMachineName())($machine_name));
  }

  public function dataProvider(): array {
    $mn_exception = new \UnexpectedValueException('The value is not correct machine name.');
    $rq_exception = new \UnexpectedValueException('The value is required.');
    return [
      ['snake_case_here', NULL],
      ['ends_with_number123', NULL],
      ['UPPER_CASE', $mn_exception],
      ['123begins_with_number', $mn_exception],
      ['0', $mn_exception],
      ['', $rq_exception],
      [NULL, $rq_exception],
      [FALSE, $mn_exception],
      [TRUE, $mn_exception],
    ];
  }

}
