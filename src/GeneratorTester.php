<?php

namespace DrupalCodeGenerator;

use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\Tests\QuestionHelper;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Twig\Loader\FilesystemLoader;

/**
 * Eases the testing of generator commands.
 */
class GeneratorTester {

  /**
   * Command to test.
   *
   * @var \Symfony\Component\Console\Command\Command
   */
  protected $command;

  /**
   * Command tester.
   *
   * @var \Symfony\Component\Console\Tester\CommandTester
   */
  protected $commandTester;

  /**
   * Working directory.
   *
   * @var string
   */
  protected $directory;

  /**
   * An associative array representing an interaction with the generator.
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
   * GeneratorTester constructor.
   */
  public function __construct(Command $command) {
    $this->command = $command;
    $this->commandTester = new CommandTester($this->command);

    $application = Application::create();

    $helper_set = $application->getHelperSet();

    // Replace default question helper to ease parsing output.
    $helper_set->set(new QuestionHelper());

    // Replace default renderer to support 'strict_variables' in tests.
    $twig_environment = new TwigEnvironment(new FilesystemLoader(), ['strict_variables' => TRUE]);
    $helper_set->set(new Renderer($twig_environment));

    $application->add($this->command);

    $this->setDirectory(sys_get_temp_dir() . '/dcg_' . uniqid());
  }

  /**
   * Getter for the directory.
   *
   * @return string
   *   The directory.
   */
  public function getDirectory() :string {
    return $this->directory;
  }

  /**
   * Setter for the directory.
   *
   * @param string $directory
   *   The directory.
   */
  public function setDirectory(string $directory) :void {
    $this->directory = $directory;
  }

  /**
   * Getter for the interaction.
   *
   * @return array
   *   The interaction.
   */
  public function getInteraction() :array {
    return $this->interaction;
  }

  /**
   * Setter for the interaction.
   *
   * @param array $interaction
   *   The interaction.
   */
  public function setInteraction(array $interaction) :void {
    $this->interaction = $interaction;
  }

  /**
   * Getter for the fixtures.
   *
   * @return array
   *   The fixtures.
   */
  public function getFixtures() :array {
    return $this->fixtures;
  }

  /**
   * Setter for the fixtures.
   *
   * @param array $fixtures
   *   The fixtures.
   */
  public function setFixtures(array $fixtures) :void {
    $this->fixtures = $fixtures;
  }

  /**
   * Executes the command.
   *
   * @return int
   *   The command exit code
   */
  public function execute() :int {
    return $this->commandTester
      ->setInputs(array_values($this->interaction))
      ->execute(['--directory' => $this->getDirectory()]);
  }

  /**
   * Gets the display returned by the last execution of the command.
   *
   * @return string
   *   The display.
   */
  public function getDisplay() :string {
    return $this->commandTester->getDisplay();
  }

  /**
   * Gets expected display.
   *
   * @return string
   *   Expected display.
   */
  public function getExpectedDisplay() :string {
    $default_name = Utils::machine2human(basename($this->directory));

    $expected_display = "\n";
    $name = $this->command->getAliases()[0] ?? $this->command->getName();
    $title = "Welcome to $name generator!";
    $expected_display .= " $title\n";
    $expected_display .= str_repeat('–', strlen($title) + 2) . "\n";

    foreach ($this->interaction as $question => $answer) {
      $question = preg_replace('/^<\d*> /', '', $question);
      $expected_display .= "\n";
      $expected_display .= " $question\n";
      // Regular question.
      if (strpos($question, "\n") === FALSE) {
        $expected_display .= " ➤ \n";
      }
      // Choice question.
      else {
        $expected_display .= "  ➤➤➤ \n";
      }
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
