<?php

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\ApplicationFactory;
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
   * Command to test.
   *
   * @var \Symfony\Component\Console\Command\Command
   */
  protected $command;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $application = ApplicationFactory::create();
    $helper_set = $application->getHelperSet();
    $helper_set->set(new QuestionHelper());

    $command_class = 'DrupalCodeGenerator\Command\\' . $this->class;
    $this->command = new $command_class();
    $application->add($this->command);

    $this->commandTester = new CommandTester($this->command);

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

    static::assertEquals($this->getExpectedDisplay(), $this->commandTester->getDisplay());
    // Tests may provide targets without fixtures.
    foreach (array_filter($this->fixtures) as $target => $fixture) {
      static::assertFileEquals($this->directory . '/' . $target, $fixture);
    }
  }

  /**
   * Gets expected display.
   *
   * @return string
   *   Expected display.
   */
  protected function getExpectedDisplay() {
    $default_name = Utils::machine2human(basename($this->directory));

    $expected_display = "\n";
    $name = $this->command->getName();
    $title = "Welcome to $name generator!";
    $expected_display .= " $title\n";
    $expected_display .= str_repeat('–', strlen($title) + 2) . "\n";

    foreach ($this->interaction as $question => $answer) {
      $expected_display .= "\n";
      $expected_display .= " $question\n";
      $expected_display .= " ➤ \n";
    }

    $expected_display = str_replace('%default_name%', $default_name, $expected_display);
    $default_machine_name = Utils::human2machine(basename($this->directory));
    $expected_display = str_replace('%default_machine_name%', $default_machine_name, $expected_display);

    $targets = implode("\n • ", array_keys($this->fixtures));
    $expected_display .= "\n";
    $expected_display .= " The following directories and files have been created or updated:\n";
    $expected_display .= "–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––\n";
    $expected_display .= " • $targets\n";
    $expected_display .= "\n";
    return $expected_display;
  }

}
