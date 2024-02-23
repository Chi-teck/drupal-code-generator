<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Event;

use DrupalCodeGenerator\Event\GeneratorInfoAlter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;

/**
 * A test for GeneratorInfoAlter event.
 */
final class GeneratorInfoAlterTest extends TestCase {

  /**
   * Test callback.
   */
  public function testGeneratorInfoAlter(): void {
    $generators = [];
    $event = new GeneratorInfoAlter($generators);
    self::assertSame([], $event->generators);

    $generators = [
      $command_1 = new Command('example-1'),
      $command_2 = new Command('example-2'),
    ];
    $event = new GeneratorInfoAlter($generators);
    $expected_generators = [
      'example-1' => $command_1,
      'example-2' => $command_2,
    ];
    self::assertSame($expected_generators, $event->generators);

  }

}
