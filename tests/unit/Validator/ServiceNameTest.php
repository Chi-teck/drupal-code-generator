<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Validator;

use DrupalCodeGenerator\Validator\ServiceName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests ServiceName validator.
 */
final class ServiceNameTest extends TestCase {

  /**
   * Test callback.
   */
  #[DataProvider('dataProvider')]
  public function test(mixed $machine_name, ?string $expected): void {
    self::assertSame($expected, (new ServiceName())($machine_name));
  }

  public static function dataProvider(): array {
    $error = 'The value is not correct service name.';
    return [
      ['snake_case_here', NULL],
      ['dot.inside', NULL],
      ['CamelCaseHere', $error],
      [' not_trimmed ', $error],
      ['.leading.dot', $error],
      ['ending.dot.', $error],
      ['special&character', $error],
      [TRUE, $error],
      [NULL, $error],
      [[], $error],
      [new \stdClass(), $error],
    ];
  }

}
