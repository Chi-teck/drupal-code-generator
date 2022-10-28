<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\RegExp;
use PHPUnit\Framework\TestCase;

/**
 * Tests RegExp validator.
 */
final class RegExpTest extends TestCase {

  /**
   * Test callback.
   *
   * @dataProvider dataProvider()
   */
  public function test(mixed $machine_name, string $pattern, ?string $message, ?\Exception $exception): void {
    $validator = new RegExp($pattern, $message);
    if ($exception) {
      $this->expectExceptionObject($exception);
    }
    self::assertSame($machine_name, $validator($machine_name));
  }

  public function dataProvider(): array {
    return [
      ['wrong', '/abc/', NULL, new \UnexpectedValueException('The value does not match pattern "/abc/".')],
      ['wrong', '/abc/', 'Custom message', new \UnexpectedValueException('Custom message')],
      ['abc', '/abc/', NULL, NULL],
      [NULL, '/abc/', NULL, new \UnexpectedValueException('The value does not match pattern "/abc/".')],
      [FALSE, '/abc/', NULL, new \UnexpectedValueException('The value does not match pattern "/abc/".')],
      [[], '/abc/', NULL, new \UnexpectedValueException('The value does not match pattern "/abc/".')],
    ];
  }

}
