<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Command\Navigation;
use DrupalCodeGenerator\GeneratorDiscovery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * A test for a whole application.
 */
class IntegrationTest extends TestCase {

  use WorkingDirectoryTrait;

  /**
   * Total count of generators.
   *
   * @var int
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
   * @var \DrupalCodeGenerator\Command\Navigation
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
   * @var \Symfony\Component\Console\Helper\HelperInterface
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
   * @var \Symfony\Component\Filesystem\Filesystem
   */
  protected $filesystem;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->initWorkingDirectory();

    $this->application = dcg_create_application();

    $discovery = new GeneratorDiscovery(new Filesystem());
    $generators = $discovery->getGenerators([DCG_ROOT . '/src/Command']);

    $this->application->addCommands($generators);

    $this->application->add(new Navigation($generators));

    $this->command = $this->application->find('navigation');

    $this->questionHelper = $this->createMock('Symfony\Component\Console\Helper\QuestionHelper');

    $this->helperSet = $this->command->getHelperSet();

    $this->commandTester = new CommandTester($this->command);

    $this->filesystem = new Filesystem();
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
  public function testExecute() {
    foreach ($this->fixtures() as $fixture) {
      $this->mockQuestionHelper($fixture['answers']);
      $this->commandTester->execute(['command' => 'navigation', '--directory' => $this->directory]);
      $this->assertEquals(implode("\n", $fixture['output']) . "\n", $this->commandTester->getDisplay());
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
          '<comment>Drupal 7</comment>',
          'Module file',
          'Example',
          'example',
        ],
        'output' => [
          'Command: d7:module-file',
          '-----------------------',
          'The following directories and files have been created or updated:',
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
          'The following directories and files have been created or updated:',
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
          '<comment>Field</comment>',
          'Formatter',
          'Foo',
          'foo',
          'Zoo',
          'foo_zoo',
        ],
        'output' => [
          'Command: formatter',
          '------------------',
          'The following directories and files have been created or updated:',
          '- src/Plugin/Field/FieldFormatter/ZooFormatter.php',
        ],
      ],
    ];

  }

}
