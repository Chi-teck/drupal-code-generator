<?php

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\Tests\WorkingDirectoryTrait;
use DrupalCodeGenerator\Utils;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Base class for generators tests.
 */
abstract class GeneratorBaseTest extends TestCase {

  use WorkingDirectoryTrait;

  protected $class;

  /**
   * Command tester.
   *
   * @var \Symfony\Component\Console\Tester\CommandTester
   */
  protected $commandTester;

  protected $fixtures;

  protected $interaction;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $command_class = 'DrupalCodeGenerator\Command\\' . $this->class;
    $command = new $command_class();
    dcg_create_application()->add($command);
    $this->commandTester = new CommandTester($command);

    $answers = array_values($this->interaction);
    $this->commandTester->setInputs($answers);

    $this->initWorkingDirectory();
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
    $this->commandTester->execute([
      '--directory' => $this->directory,
    ]);
    static::assertEquals($this->getExpectedDisplay(), $this->getDisplay());
    // Tests may provide targets without fixtures.
    foreach (array_filter($this->fixtures) as $target => $fixture) {
      static::assertFileEquals($this->directory . '/' . $target, $fixture);
    }
  }

  /**
   * Gets the display returned by the last execution of the command.
   *
   * @return string
   *   The display.
   */
  protected function getDisplay() {
    // Remove autocomplete output.
    return preg_replace(
      '/ > (.*)The following directories/', ' > The following directories',
      $this->commandTester->getDisplay()
    );
  }

  /**
   * Gets expected display.
   *
   * @return string
   *   Expected display.
   */
  protected function getExpectedDisplay() {
    $default_name = Utils::machine2human(basename($this->directory));
    $expected_display = str_replace('%default_name%', $default_name, implode(array_keys($this->interaction)));
    $default_machine_name = Utils::human2machine(basename($this->directory));
    $expected_display = str_replace('%default_machine_name%', $default_machine_name, $expected_display);
    $targets = implode("\n- ", array_keys($this->fixtures));
    $expected_display .= "The following directories and files have been created or updated:\n- $targets\n";
    return $expected_display;
  }

}
