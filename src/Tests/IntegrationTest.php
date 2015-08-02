<?php
namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Commands\Other;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use DrupalCodeGenerator\GeneratorsDiscovery;
use DrupalCodeGenerator\Commands;
use Symfony\Component\Filesystem\Filesystem;

class IntegrationTest extends \PHPUnit_Framework_TestCase {

  const DESTINATION = DCG_ROOT . '/sandbox/tests';

  /**
   * @var \Symfony\Component\Console\Application $application
   */
  protected $application;

  /**
   * @var \Symfony\Component\Console\Command\Command $command
   */
  protected $command;

  /**
   * @var array
   */
  protected $fixtures;

  /**
   * @var \Symfony\Component\Console\Helper\HelperInterface $questionHelper
   */
  protected $questionHelper;

  /**
   * @var \Symfony\Component\Console\Helper\HelperSet $helperSet
   */
  protected $helperSet;

  /**
   * @var \Symfony\Component\Console\Tester\CommandTester commandTester
   */
  protected $commandTester;

  protected $filesystem;

  /**
   * {@inheritdoc}
   */
  public function setUp() {

    $this->application = new Application('Drupal Code Generator', '@git-version@');


    $filesystem = new Filesystem();
    $twig_loader = new \Twig_Loader_Filesystem(DCG_ROOT . '/src/Resources/templates');
    $twig = new \Twig_Environment($twig_loader);

    $discovery = new GeneratorsDiscovery([dirname(__DIR__) . '/Commands'], $filesystem, $twig);
    $generators = $discovery->getGenerators();
    $this->application->addCommands($generators);

    $navigation = new Commands\Navigation();
    $navigation->init($generators);
    $this->application->add($navigation);

    $this->command = $this->application->find('navigation');

    $this->fixtures = require 'integration-fixtures.php';

    $this->questionHelper = $this->getMock('Symfony\Component\Console\Helper\QuestionHelper', ['ask']);

    $this->helperSet = $this->command->getHelperSet();

    $this->commandTester = new CommandTester($this->command);

    $this->filesystem = new Filesystem();
  }

  /**
   * Test callback.
   */
  public function testExecute() {
    foreach ($this->fixtures as $fixture) {
      $this->mockQuestionHelper($fixture['answers']);
      $this->commandTester->execute(['command' => 'navigation', '--destination' => './sandbox/tests']);
      $this->assertEquals(implode("\n", $fixture['output']) . "\n", $this->commandTester->getDisplay());

      $this->filesystem->remove(self::DESTINATION);
    }
  }

  /**
   * Mock question helper.
   */
  protected function mockQuestionHelper(array $answers) {

    foreach ($answers as $key => $answer) {
      $this->questionHelper->expects($this->at($key))
        ->method('ask')
        ->will($this->returnValue($answer));
    }

    $this->helperSet->set($this->questionHelper, 'question');
  }

}
