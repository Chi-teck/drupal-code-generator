<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\RequiredMachineName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests RequiredMachineName validator.
 */
final class RequiredMachineNameTest extends TestCase {

  /**
   * Test callback.
   */
  #[DataProvider('dataProvider')]
  public function test(mixed $machine_name, $expected): void {
    self::assertSame($expected, (new RequiredMachineName())($machine_name));
  }

  public static function dataProvider(): array {
    $mn_error = 'The value is not correct machine name.';
    $rq_error = 'The value is required.';
    return [
      ['snake_case_here', NULL],
      ['ends_with_number123', NULL],
      ['UPPER_CASE', $mn_error],
      ['123begins_with_number', $mn_error],
      ['0', $mn_error],
      ['', $rq_error],
      [NULL, $rq_error],
      [FALSE, $mn_error],
      [TRUE, $mn_error],
    ];
  }

}
