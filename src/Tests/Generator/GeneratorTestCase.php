<?php

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\Tests\WorkingDirectoryTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Base class for generators tests.
 */
abstract class GeneratorTestCase extends TestCase {

  use WorkingDirectoryTrait;

  protected $application;

  /**
   * Generator command to be tested.
   *
   * @var \Symfony\Component\Console\Command\Command
   */
  protected $command;

  protected $commandName;

  protected $answers = [];

  protected $commandTester;

  protected $display;

  protected $fixtures;

  protected $filesystem;

  protected $class;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $command_class = 'DrupalCodeGenerator\Command\\' . $this->class;
    $this->command = new $command_class();
    $this->commandName = $this->command->getName();

    $this->application = dcg_create_application();
    $this->application->add($this->command);

    $this->commandTester = new CommandTester($this->command);
    $this->mockQuestionHelper();
    $this->initWorkingDirectory();
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    $this->removeWorkingDirectory();
  }

  /**
   * Mocks question helper.
   */
  protected function mockQuestionHelper() {
    $question_helper = $this->createMock('Symfony\Component\Console\Helper\QuestionHelper');

    // The answers can be either a numeric array or an associated array keyed by
    // question text (preferable format).
    if (isset($this->answers[0])) {
      foreach ($this->answers as $key => $answer) {
        $question_helper
          ->expects($this->at($key + 2))
          ->method('ask')
          ->willReturn($answer);
      }
    }
    else {
      $question_helper
        ->method('ask')
        ->will($this->returnCallback(function () {
          $question = func_get_arg(2);
          preg_match('#<info>(.*)</info>#', $question->getQuestion(), $match);
          $answer = $this->answers[$match[1]];
          is_bool($answer)
            ? $this->assertInstanceOf(ConfirmationQuestion::class, $question)
            : $this->assertNotInstanceOf(ConfirmationQuestion::class, $question);
          return $answer;
        }));
    }

    // We override the question helper with our mock.
    $this->command->getHelperSet()->set($question_helper, 'question');
  }

  /**
   * {@inheritdoc}
   */
  protected function doTest() {
    $this->removeWorkingDirectory();
    $this->commandTester->execute([
      'command' => $this->command->getName(),
      '--directory' => $this->directory,
    ]);

    $this->display = $this->commandTester->getDisplay();
    $targets = implode("\n- ", array_keys($this->fixtures));
    $output = "The following directories and files have been created or updated:\n- $targets\n";
    $this->assertEquals($output, $this->commandTester->getDisplay());
    // Tests may provide targets without fixtures.
    foreach (array_filter($this->fixtures) as $target => $fixture) {
      $this->checkFile($target, $fixture);
    }
  }

  /**
   * Checks the file.
   *
   * @param string $file
   *   The file to check.
   * @param string $fixture
   *   The fixture to compare the file content.
   */
  protected function checkFile($file, $fixture) {
    $this->assertFileExists($this->directory . '/' . $file);
    $this->assertFileEquals($this->directory . '/' . $file, $fixture);
  }

  /**
   * Test callback.
   */
  public function testGenerator() {
    $this->doTest();
  }

}
