<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Event;

use DrupalCodeGenerator\Event\GeneratorInfo;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;

/**
 * A test for generator info event.
 */
final class GeneratorInfoTest extends TestCase {

  /**
   * Test callback.
   */
  public function testGeneratorInfo(): void {
    $generators = [];
    $event = new GeneratorInfo($generators);
    self::assertSame([], $generators);

    $generator_1 = new Command('example-1');
    $generator_2 = new Command('example-1');
    $event->addGenerators($generator_1, $generator_2);
    self::assertSame([$generator_1, $generator_2], $generators);
  }

}
