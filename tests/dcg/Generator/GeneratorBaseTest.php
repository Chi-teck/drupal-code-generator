<?php

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\Tests\QuestionHelper;
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
    $application = dcg_create_application();
    $helper_set = $application->getHelperSet();
    $helper_set->set(new QuestionHelper());

    $command_class = 'DrupalCodeGenerator\Command\\' . $this->class;
    $command = new $command_class();
    $application->add($command);

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
    return str_replace("\n➤ ", '', $this->commandTester->getDisplay());
  }

  /**
   * Gets expected display.
   *
   * @return string
   *   Expected display.
   */
  protected function getExpectedDisplay() {
    $default_name = Utils::machine2human(basename($this->directory));
    $expected_display = str_replace('%default_name%', $default_name, implode("\n", array_keys($this->interaction))) . "\n";
    $default_machine_name = Utils::human2machine(basename($this->directory));
    $expected_display = str_replace('%default_machine_name%', $default_machine_name, $expected_display);
    $targets = implode("\n• ", array_keys($this->fixtures));
    $expected_display .= "\n";
    $expected_display .= "The following directories and files have been created or updated:\n";
    $expected_display .= "–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––\n";
    $expected_display .= "• $targets\n";
    return $expected_display;
  }

}
