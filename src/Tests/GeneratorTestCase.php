<?php
namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Command\Other;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;


class GeneratorTestCase extends \PHPUnit_Framework_TestCase {

  protected $application;

  /** @var  \Symfony\Component\Console\Command\Command $command */
  protected $command;

  protected $commandName;

  protected $answers;

  protected $commandTester;

  protected $display;

  protected $target;

  protected $fixture;

  public function setUp() {

    $this->application = new Application();
    $this->application->add($this->command);

    $this->application->find($this->commandName);

    $this->mockQuestionHelper();
    $this->commandTester = new CommandTester($this->command);

  }

  protected function mockQuestionHelper() {

    $questionHelper = $this->getMock('Symfony\Component\Console\Helper\QuestionHelper', ['ask']);

    foreach ($this->answers as $key => $answer) {
      $questionHelper->expects($this->at($key))
        ->method('ask')
        ->will($this->returnValue($answer));
    }

    // We override the question helper with our mock
    $this->command->getHelperSet()->set($questionHelper, 'question');

  }

  protected function execute() {
    $this->commandTester->execute([
      'command' => $this->commandName,
      '--dir' => 'sandbox'
    ]);

    $this->display = $this->commandTester->getDisplay();
  }

  protected function checkFile($file, $fixture) {
    $this->assertFileExists("./sandbox/$file");
    $this->assertFileEquals("./sandbox/$file", "$fixture");
  }

  /**
   * Test callback.
   */
  public function testExecute() {

    $this->execute();

    $this->assertRegExp('/The following files have been created:/', $this->display);
    $this->assertRegExp("/$this->target/", $this->display);

    $this->checkFile($this->target, $this->fixture);

  }


}