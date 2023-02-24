<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\Choice;
use PHPUnit\Framework\TestCase;

/**
 * Tests choice validator.
 */
final class ChoiceTest extends TestCase {

  /**
   * Test callback.
   *
   * @dataProvider dataProvider()
   */
  public function test(mixed $value, array $choices, ?string $message, ?\UnexpectedValueException $exception): void {
    $validator = $message ? new Choice($choices, $message) : new Choice($choices);
    if ($exception) {
      $this->expectExceptionObject($exception);
    }
    self::assertSame($value, $validator($value));
  }

  public function dataProvider(): array {
    $default_exception = new \UnexpectedValueException('The value you selected is not a valid choice.');
    return [
      ['wrong', ['aaa', 'bbb'], NULL, $default_exception],
      ['aaa', ['aaa', 'bbb'], NULL, NULL],
      ['wrong', ['aaa', 'bbb'], 'Custom message.', new \UnexpectedValueException('Custom message.')],
      [111, ['111', '222'], NULL, $default_exception],
      ['111', [111, 222], NULL, $default_exception],
      [111, [111, 222], NULL, NULL],
      [FALSE, ['aaa', 'bbb'], NULL, $default_exception],
      [[], ['aaa', 'bbb'], NULL, $default_exception],
    ];
  }

}
