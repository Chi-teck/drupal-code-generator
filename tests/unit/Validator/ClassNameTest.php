<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\ClassName;
use PHPUnit\Framework\TestCase;

/**
 * Tests ClassName validator.
 */
final class ClassNameTest extends TestCase {

  /**
   * Test callback.
   *
   * @dataProvider dataProvider()
   */
  public function test(mixed $machine_name, ?\Exception $exception): void {
    if ($exception) {
      $this->expectExceptionObject($exception);
    }
    self::assertSame($machine_name, (new ClassName())($machine_name));
  }

  public function dataProvider(): array {
    $exception = new \UnexpectedValueException('The value is not correct class name.');
    return [
      ['Single', NULL],
      ['UpperCamelCase', NULL],
      ['lowCamelCase', $exception],
      ['snake_case_here', $exception],
      ['With Space', $exception],
      [' NotTrimmed ', $exception],
      ['With_Underscore', $exception],
      ['WrongSymbols@)@#&)', $exception],
      [TRUE, $exception],
      [NULL, $exception],
      [[], $exception],
      [new \stdClass(), $exception],
    ];
  }

}
