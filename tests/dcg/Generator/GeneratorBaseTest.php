<?php

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\GeneratorTester;
use DrupalCodeGenerator\Tests\WorkingDirectoryTrait;
use PHPUnit\Framework\TestCase;

/**
 * Base class for generators tests.
 */
abstract class GeneratorBaseTest extends TestCase {

  use WorkingDirectoryTrait;

  protected $class;

  /**
   * Generator tester.
   *
   * @var \DrupalCodeGenerator\GeneratorTester
   */
  protected $tester;

  protected $fixtures;

  protected $interaction;

  /**
   * Command to test.
   *
   * @var \Symfony\Component\Console\Command\Command
   */
  protected $command;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->initWorkingDirectory();

    $command_class = 'DrupalCodeGenerator\Command\\' . $this->class;

    $this->tester = new GeneratorTester(new $command_class());

    $this->tester->setDirectory($this->directory);

    $this->tester->setInteraction($this->interaction);

    $this->tester->setFixtures($this->fixtures);
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    $this->removeWorkingDirectory();
  }

  /**
   * Test callback.
   */
  public function testGenerator() {

    $this->tester->execute();

    static::assertEquals($this->getExpectedDisplay(), $this->getDisplay());

    foreach (array_filter($this->tester->getFixtures()) as $target => $fixture) {
      static::assertFileEquals($this->tester->getDirectory() . '/' . $target, $fixture);
    }
  }

  /**
   * Returns the display returned by the last execution of the command.
   *
   * @return string
   *   The display.
   */
  protected function getDisplay() {
    return $this->tester->getDisplay();
  }

  /**
   * Returns expected display.
   *
   * @return string
   *   Expected display.
   */
  protected function getExpectedDisplay() {
    return $this->tester->getExpectedDisplay();
  }

}
