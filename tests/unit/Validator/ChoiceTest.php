<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\Choice;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests choice validator.
 */
final class ChoiceTest extends TestCase {

  /**
   * Test callback.
   */
  #[DataProvider('dataProvider')]
  public function test(mixed $value, array $choices, ?string $message, ?string $expected): void {
    $validator = $message ? new Choice($choices, $message) : new Choice($choices);
    self::assertSame($expected, $validator($value));
  }

  public static function dataProvider(): array {
    $default_error = 'The value you selected is not a valid choice.';
    return [
      ['wrong', ['aaa', 'bbb'], NULL, $default_error],
      ['aaa', ['aaa', 'bbb'], NULL, NULL],
      ['wrong', ['aaa', 'bbb'], 'Custom message.', 'Custom message.'],
      [111, ['111', '222'], NULL, $default_error],
      ['111', [111, 222], NULL, $default_error],
      [111, [111, 222], NULL, NULL],
      [FALSE, ['aaa', 'bbb'], NULL, $default_error],
      [[], ['aaa', 'bbb'], NULL, $default_error],
    ];
  }

}
