<?php

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\GeneratorTester;
use DrupalCodeGenerator\Tests\BaseTestCase;

/**
 * Base class for generators tests.
 */
abstract class GeneratorBaseTest extends BaseTestCase {

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
    parent::setUp();

    $command_class = 'DrupalCodeGenerator\Command\\' . $this->class;

    $this->tester = new GeneratorTester(new $command_class());

    $this->tester->setDirectory($this->directory);

    $this->tester->setInteraction($this->interaction);

    $this->tester->setFixtures($this->fixtures);
  }

  /**
   * Test callback.
   */
  public function testGenerator() {

    $this->tester->execute();

    static::assertEquals($this->getExpectedDisplay(), $this->getDisplay());

    foreach ($this->tester->getFixtures() as $target => $fixture) {
      $path = $this->tester->getDirectory() . '/' . $target;
      if (is_array($fixture)) {
        self::assertDirectoryExists($path);
      }
      elseif ($fixture !== NULL) {
        self::assertFileEquals($path, $fixture);
      }
      else {
        self::markTestSkipped();
      }
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
