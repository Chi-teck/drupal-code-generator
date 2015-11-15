<?php
namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Commands\Other;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Twig_Loader_Filesystem;
use Twig_Environment;

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

    $this->filesystem = new Filesystem();
    $twig_loader = new Twig_Loader_Filesystem(DCG_ROOT . '/src/Templates');
    $twig = new Twig_Environment($twig_loader);

    $command_class = 'DrupalCodeGenerator\Commands\\' . $this->class;
    $this->command = new $command_class($this->filesystem, $twig);
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
    $this->filesystem = new Filesystem();
    $this->filesystem->remove($this->destination);
  }

  /**
   * Mocks question helper.
   */
  protected function mockQuestionHelper() {

    $question_helper = $this->getMock('Symfony\Component\Console\Helper\QuestionHelper', ['ask']);

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
