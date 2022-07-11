<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\MachineName;
use DrupalCodeGenerator\Validator\Optional;
use PHPUnit\Framework\TestCase;

/**
 * Tests Optional validator.
 */
final class OptionalTest extends TestCase {

  /**
   * Test callback.
   *
   * @dataProvider dataProvider()
   */
  public function test(mixed $machine_name, ?\Exception $exception): void {
    if ($exception) {
      $this->expectExceptionObject($exception);
    }
    $validator = new Optional(new MachineName());
    self::assertSame($machine_name, $validator($machine_name));
  }

  public function dataProvider(): array {
    $exception = new \UnexpectedValueException('The value is not correct machine name.');
    return [
      ['foo*&)(*&@#()*&@#bar', $exception],
      [TRUE, $exception],
      [NULL, NULL],
      ['', NULL],
      [' ', $exception],
      [new \stdClass(), $exception],
    ];
  }

}
