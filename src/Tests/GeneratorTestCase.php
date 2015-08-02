<?php
namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Commands\Other;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Twig_Loader_Filesystem;
use Twig_Environment;

// @TODO: Cleanup.
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

  protected $filesystem;

  protected $class;

  protected $destination = DCG_SANDBOX . '/tests';

  public function setUp() {

    $this->filesystem = new Filesystem();
    $twig_loader = new Twig_Loader_Filesystem(DCG_ROOT . '/src//Resources/templates');
    $twig = new Twig_Environment($twig_loader);


    $command_class = 'DrupalCodeGenerator\Commands\\' . $this->class;
    $this->command = new $command_class($this->filesystem, $twig);
    $this->commandName = $this->command->getName();

    $this->application = new Application();
    $this->application->add($this->command);

    $this->mockQuestionHelper();
    $this->commandTester = new CommandTester($this->command);

  }

  public function tearDown() {
    $this->filesystem = new Filesystem();
    $this->filesystem->remove($this->destination);
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
      'command' => $this->command->getName(),
      '--destination' => $this->destination
    ]);

    $this->display = $this->commandTester->getDisplay();
  }

  protected function checkFile($file, $fixture) {
    $this->assertFileExists($this->destination . '/'. $file);
    $this->assertFileEquals($this->destination. '/'. $file, "$fixture");
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
