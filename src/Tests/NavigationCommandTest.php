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

    $helper = $navigation->getHelper('question');

    $answers = [
      1, 1, 0, 2, 0, 0,
      2, 1, 0, 2, 0, 3, 0, 4, 0, 5, 0, 6, 0, 7, 0, 0,
      3, 0,
      9, 0, 0,
    ];
    $helper->setInputStream($this->getInputStream(implode("\n", $answers)));

    $commandTester = new CommandTester($navigation);
    $commandTester->execute(['command' => $navigation->getName(), '--directory' => $this->directory]);

    $expected_output = trim(file_get_contents(__DIR__ . '/_navigation-fixture.txt'));
    $output = trim($commandTester->getDisplay());
    $this->assertEquals($expected_output, $output);
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
