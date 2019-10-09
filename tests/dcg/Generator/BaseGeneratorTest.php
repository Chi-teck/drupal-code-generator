<?php

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\GeneratorTester;
use DrupalCodeGenerator\Tests\BaseTestCase;

/**
 * Base class for generators tests.
 */
abstract class BaseGeneratorTest extends BaseTestCase {

  /**
   * Command class to be tested.
   *
   * @var string
   */
  protected $class;

  /**
   * The interaction.
   *
   * This should be represented as an associative array where keys are questions
   * and values are user answers.
   *
   * @var array
   */
  protected $interaction = [];

  /**
   * The fixtures.
   *
   * @var array
   */
  protected $fixtures = [];

  /**
   * Command to test.
   *
   * @var \Symfony\Component\Console\Command\Command
   */
  protected $command;

  /**
   * Path to fixtures.
   *
   * @var string
   */
  protected $fixturePath = '';

  /**
   * Test callback.
   */
  public function testGenerator(): void {
    if ($this->interaction || $this->fixtures) {
      $this->doTest($this->interaction, $this->fixtures);
    }
    else {
      // Nothing to test here because the child class probably declares own test
      // callbacks. Increment the assertion counter to suppress a warning about
      // risky tests.
      $this->addToAssertionCount(1);
    }
  }

  /**
   * Executes tests using provided interaction and fixtures.
   */
  public function doTest(array $interaction, array $fixtures): void {

    $command_class = 'DrupalCodeGenerator\Command\\' . $this->class;

    $tester = new GeneratorTester(new $command_class());
    $tester->setDirectory($this->directory);
    $tester->setInteraction($interaction);
    $tester->setFixtures($fixtures);
    $tester->execute();

    $expected_display = $this->processExpectedDisplay($tester->getExpectedDisplay());
    self::assertEquals($expected_display, $tester->getDisplay());

    // Default fixture path is the directory where the test is located.
    if (!$fixture_path = $this->fixturePath) {
      $reflector = new \ReflectionClass(get_class($this));
      $fixture_path = dirname($reflector->getFileName()) . '/';
    }

    foreach ($tester->getFixtures() as $target => $fixture) {
      $path = $tester->getDirectory() . '/' . $target;
      if (is_array($fixture)) {
        self::assertDirectoryExists($path);
      }
      elseif ($fixture !== NULL) {
        self::assertFileEquals($fixture_path . $fixture, $path, $fixture);
      }
      else {
        self::markTestIncomplete();
      }
    }
  }

  /**
   * Processed the display from command.
   *
   * @param string $display
   *   The display to process.
   *
   * @return string
   *   The processed display.
   */
  protected function processExpectedDisplay(string $display): string {
    return $display;
  }

}
