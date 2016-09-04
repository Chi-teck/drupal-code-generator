<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Commands\Navigation;
use DrupalCodeGenerator\GeneratorDiscovery;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * A test for a whole application.
 */
class IntegrationTest extends \PHPUnit_Framework_TestCase {

  /**
   * Total count of genetators.
   *
   * @var integer
   */
  protected $totalGenerators;

  /**
   * The application.
   *
   * @var \Symfony\Component\Console\Application
   */
  protected $application;

  /**
   * The navigation command.
   *
   * @var \DrupalCodeGenerator\Commands\Navigation
   */
  protected $command;

  /**
   * Sample answers and output for testing.
   *
   * @var array
   *
   * @see integration-fixtures.php
   */
  protected $fixtures;

  /**
   * The question helper.
   *
   * @var \Symfony\Component\Console\Helper\HelperInterface;
   */
  protected $questionHelper;

  /**
   * The helper set.
   *
   * @var \Symfony\Component\Console\Helper\HelperSet
   */
  protected $helperSet;

  /**
   * The command tester.
   *
   * @var \Symfony\Component\Console\Tester\CommandTester
   */
  protected $commandTester;

  /**
   * The filesystem utility.
   *
   * @var \Symfony\Component\Filesystem\Filesystem;
   */
  protected $filesystem;

  /**
   * The destination directory.
   *
   * @var string
   *
   * @see Navigation::configure()
   */
  protected $destination;

  /**
   * {@inheritdoc}
   */
  public function setUp() {

    $this->application = new Application('Drupal Code Generator', '@git-version@');
    $discovery = new GeneratorDiscovery([DCG_ROOT . '/src/Commands'], [DCG_ROOT . '/src/Templates'], new Filesystem());
    $generators = $discovery->getGenerators();

    $this->application->addCommands($generators);

    $navigation = new Navigation();
    $navigation->init($generators);
    $this->application->add($navigation);

    $this->command = $this->application->find('navigation');

    $this->questionHelper = $this->createMock('Symfony\Component\Console\Helper\QuestionHelper');

    $this->helperSet = $this->command->getHelperSet();

    $this->commandTester = new CommandTester($this->command);

    $this->filesystem = new Filesystem();

    $this->destination = DCG_SANDBOX . '/tests';
  }

  /**
   * Test callback.
   */
  public function testExecute() {
    foreach ($this->fixtures() as $fixture) {
      $this->mockQuestionHelper($fixture['answers']);
      $this->commandTester->execute(['command' => 'navigation', '--destination' => './sandbox/tests']);
      $this->assertEquals(implode("\n", $fixture['output']) . "\n", $this->commandTester->getDisplay());
      $this->filesystem->remove($this->destination);
    }
  }

  /**
   * Mocks question helper.
   */
  protected function mockQuestionHelper(array $answers) {
    foreach ($answers as $key => $answer) {
      $this->questionHelper->expects($this->at($key + 2))
        ->method('ask')
        ->will($this->returnValue($answer));
    }

    $this->helperSet->set($this->questionHelper, 'question');
  }

  /**
   * Returns fixtures for testing navigation.
   */
  protected function fixtures() {
    return [
      [
        'answers' => [
          '<comment>Drupal 6</comment>',
          'Info (module)',
          'Example',
          'example',
          'Some description',
          'custom',
          '6.x-1.0',
        ],
        'output' => [
          'Command: d6:module-info',
          '-----------------------',
          'The following files have been created:',
          '- example.info',
        ],
      ],
      [
        'answers' => [
          '<comment>Drupal 7</comment>',
          'Module file',
          'Example',
          'example',
        ],
        'output' => [
          'Command: d7:module-file',
          '-----------------------',
          'The following files have been created:',
          '- example.module',
        ],
      ],
      [
        'answers' => [
          '<comment>Drupal 7</comment>',
          'settings.php',
          'mysql',
          'drupal',
          'root',
          '123',
        ],
        'output' => [
          'Command: d7:settings.php',
          '------------------------',
          'The following files have been created:',
          '- settings.php',
        ],
      ],

      [
        'answers' => [
          '<comment>Drupal 8</comment>',
          '<comment>Plugin</comment>',
          // Test jumping on upper menu level.
          '..',
          '<comment>Plugin</comment>',
          'Field formatter',
          'Foo',
          'foo',
          'Zoo',
          'foo_zoo',
        ],
        'output' => [
          'Command: d8:plugin:field-formatter',
          '----------------------------------',
          'The following files have been created:',
          '- ZooFormatter.php',
        ],
      ],
    ];

  }

}
