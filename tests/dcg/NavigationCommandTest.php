<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Command\Navigation;
use DrupalCodeGenerator\GeneratorDiscovery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * A test for navigation command.
 */
class NavigationCommandTest extends TestCase {

  use WorkingDirectoryTrait;

  /**
   * Test callback.
   */
  public function testExecute() {

    $this->initWorkingDirectory();

    // Create navigation command.
    $discovery = new GeneratorDiscovery(new Filesystem());
    $generators = $discovery->getGenerators([DCG_ROOT . '/src/Command']);

    $application = new Application();
    $application->addCommands($generators);

    $navigation = new Navigation($generators);
    $application->add($navigation);

    $answers = [
      1, 1, 0, 2, 0, 0,
      2, 1, 0, 2, 0, 3, 0, 4, 0, 5, 0, 6, 0, 7, 1, 0, 0, 0,
      3, 0,
      9, 0, 0,
    ];

    $command_tester = new CommandTester($navigation);
    $command_tester->setInputs($answers);

    $options = ['directory' => $this->directory];
    $command_tester->execute(['command' => $navigation->getName()], $options);

    $expected_output = trim(file_get_contents(__DIR__ . '/_navigation_fixture.txt'));
    $output = trim($command_tester->getDisplay());
    static::assertEquals($expected_output, $output);

    // Make sure it does not fail when starting with default alias.
    $command_tester->setInputs([0, 0, 0]);
    $command_tester->execute(['command' => 'yml'], $options);
  }

  /**
   * Returns input stream.
   */
  protected function getInputStream($input) {
    $stream = fopen('php://memory', 'r+', FALSE);
    fwrite($stream, $input);
    rewind($stream);
    return $stream;
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    $this->removeWorkingDirectory();
  }

}
