<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Commands\Other;
use DrupalCodeGenerator\TwigEnvironment;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Dumper;
use Twig_Loader_Filesystem;

/**
 * Base class for generators tests.
 *
 * @TODO: Cleanup.
 */
abstract class GeneratorTestCase extends \PHPUnit_Framework_TestCase {

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

  protected $target;

  protected $fixture;

  protected $filesystem;

  protected $class;

  protected $destination;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $command_class = 'DrupalCodeGenerator\Commands\\' . $this->class;
    $this->command = $command_class::create([DCG_ROOT . '/src/Templates']);
    $this->commandName = $this->command->getName();

    $this->application = new Application();
    $this->application->add($this->command);

    $this->mockQuestionHelper();
    $this->commandTester = new CommandTester($this->command);

    $this->destination = DCG_SANDBOX . '/tests';

  }

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    $filesystem = new Filesystem();
    $filesystem->remove($this->destination);
  }

  /**
   * Mocks question helper.
   */
  protected function mockQuestionHelper() {

    $question_helper = $this->createMock('Symfony\Component\Console\Helper\QuestionHelper');

    foreach ($this->answers as $key => $answer) {
      $question_helper->expects($this->at($key))
        ->method('ask')
        ->will($this->returnValue($answer));
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
      '--destination' => $this->destination
    ]);

    $this->display = $this->commandTester->getDisplay();
  }

  /**
   * Checks file.
   */
  protected function checkFile($file, $fixture) {
    $this->assertFileExists($this->destination . '/' . $file);
    $this->assertFileEquals($this->destination . '/' . $file, "$fixture");
  }

  /**
   * Test callback.
   */
  public function testExecute() {

    $this->execute();

    $output = "The following files have been created:\n- $this->target\n";

    $this->assertEquals($output, $this->commandTester->getDisplay());

    $this->checkFile($this->target, $this->fixture);
  }

}
