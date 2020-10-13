<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\Navigation;
use DrupalCodeGenerator\GeneratorFactory;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Tester\TesterTrait;

/**
 * A test for navigation command.
 *
 * @todo Clean-up
 */
final class NavigationCommandTest extends BaseTestCase {

  use TesterTrait;

  /**
   * Test callback.
   */
  public function testNavigation(): void {

    $factory = new GeneratorFactory();
    $generators = $factory->getGenerators([Application::ROOT . '/src/Command']);

    $application = Application::create();
    $application->setAutoExit(FALSE);

    $helper_set = $application->getHelperSet();
    $helper_set->set(new QuestionHelper());

    $application->addCommands($generators);
    $navigation = new Navigation();
    $application->add($navigation);

    $fixture = \file_get_contents(__DIR__ . '/_navigation_fixture.txt');

    // The return symbol is used to identify user input in fixture.
    \preg_match_all('/\s([^\s]+)⏎/', $fixture, $matches);

    $this->input = new ArrayInput(['command' => 'navigation', '--working-dir' => $this->directory]);
    $this->input->setStream(self::createStream($matches[1]));
    $this->output = new StreamOutput(\fopen('php://memory', 'w'));

    $application->run($this->input, $this->output);

    $expected_output = \rtrim(\preg_replace('/[^\s]+⏎/', '', $fixture));
    $output = \rtrim($this->getDisplay());

    self::assertSame($expected_output, $output);

    /** @var \Symfony\Component\Console\Command\HelpCommand $help */
    $help = $application->find('help');
    $help->setCommand($navigation);
    $command_tester = new CommandTester($help);
    $command_tester->execute([]);
    $display = $command_tester->getDisplay();
    self::assertStringContainsString('Command line code generator', $display);
    self::assertStringContainsString('dcg [options] <generator>', $display);
    self::assertStringContainsString('Display navigation', $display);
    self::assertStringContainsString('List all available generators', $display);
  }

}
