<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\ApplicationFactory;
use DrupalCodeGenerator\Command\Navigation;
use DrupalCodeGenerator\GeneratorDiscovery;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * A test for navigation command.
 */
class NavigationCommandTest extends BaseTestCase {

  /**
   * Test callback.
   */
  public function testExecute() {

    // Create navigation command.
    $discovery = new GeneratorDiscovery(new Filesystem());
    $generators = $discovery->getGenerators([ApplicationFactory::getRoot() . '/src/Command']);

    $application = ApplicationFactory::create();
    $helper_set = $application->getHelperSet();
    $helper_set->set(new QuestionHelper());

    $application->addCommands($generators);

    $navigation = new Navigation($generators);
    $application->add($navigation);

    $command_tester = new CommandTester($navigation);

    $fixture = file_get_contents(__DIR__ . '/_navigation_fixture.txt');

    // The return symbol is used to identify user input in fixture.
    preg_match_all('/\s([^\s]+)⏎/', $fixture, $matches);
    $command_tester->setInputs($matches[1]);

    $input = ['command' => $navigation->getName(), '--directory' => $this->directory];
    $command_tester->execute($input);

    $expected_output = rtrim(preg_replace('/[^\s]+⏎/', '', $fixture));
    $output = rtrim($command_tester->getDisplay());
    static::assertEquals($expected_output, $output);

    // Make sure it does not fail when starting with default alias.
    $command_tester->setInputs([0, 0, 0]);
    $command_tester->execute(['command' => 'yml']);
  }

}
