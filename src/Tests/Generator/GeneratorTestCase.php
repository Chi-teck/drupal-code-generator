<?php

namespace DrupalCodeGenerator\Tests\Generator;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Base class for generators tests.
 */
abstract class GeneratorTestCase extends TestCase {

  protected $application;

  /**
   * Generator command to be tested.
   *
   * @var \Symfony\Component\Console\Command\Command
   */
  protected $command;

  protected $commandName;

  protected $answers;

  protected $commandTester;

  protected $display;

  protected $fixtures;

  protected $filesystem;

  protected $class;

  protected $destination;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $command_class = 'DrupalCodeGenerator\Command\\' . $this->class;
    $this->command = new $command_class();
    $this->commandName = $this->command->getName();

    $this->application = dcg_create_application();
    $this->application->add($this->command);

    $this->mockQuestionHelper();
    $this->commandTester = new CommandTester($this->command);

    $this->destination = DCG_SANDBOX . '/tests';
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    (new Filesystem())->remove($this->destination);
  }

  /**
   * Mocks question helper.
   */
  protected function mockQuestionHelper() {
    $question_helper = $this->createMock('Symfony\Component\Console\Helper\QuestionHelper');

    foreach ($this->answers as $key => $answer) {
      // @TODO: Figure out where this key offset comes from.
      $question_helper->expects($this->at($key + 2))
        ->method('ask')
        ->willReturn($answer);
    }

    // We override the question helper with our mock.
    $this->command->getHelperSet()->set($question_helper, 'question');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute() {
    $this->commandTester->execute([
      'command' => $this->command->getName(),
      '--directory' => $this->destination,
    ]);

    $this->display = $this->commandTester->getDisplay();
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
    $this->assertFileExists($this->destination . '/' . $file);
    $this->assertFileEquals($this->destination . '/' . $file, $fixture);
  }

  /**
   * Test callback.
   */
  public function testExecute() {
    $this->execute();
    $targets = implode("\n- ", array_keys($this->fixtures));
    $output = "The following directories and files have been created or updated:\n- $targets\n";
    $this->assertEquals($output, $this->commandTester->getDisplay());
    // Tests may provide targets without fixtures.
    foreach (array_filter($this->fixtures) as $target => $fixture) {
      $this->checkFile($target, $fixture);
    }
  }

}
