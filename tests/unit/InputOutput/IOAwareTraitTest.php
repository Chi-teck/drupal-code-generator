<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\InputOutput;

use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\InputOutput\IO;
use DrupalCodeGenerator\InputOutput\IOAwareTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * A test for IOAwareTrait trait.
 */
final class IOAwareTraitTest extends TestCase {

  /**
   * Test callback.
   */
  public function testTrait(): void {
    $io = new IO(
      new ArrayInput([]),
      new BufferedOutput(),
      new QuestionHelper(),
    );

    $instance = new class () {
      use IOAwareTrait;
    };
    $instance->io($io);
    self::assertInstanceOf(IO::class, $instance->io());
  }

  /**
   * Test callback.
   */
  public function testException(): void {
    $instance = new class () {
      use IOAwareTrait;
    };
    self::expectExceptionObject(new \LogicException('IO is not initialized yet.'));
    $instance->io();
  }

}
