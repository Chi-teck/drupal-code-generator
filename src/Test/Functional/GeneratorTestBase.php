<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Test\Functional;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Base class for generator tests.
 */
abstract class GeneratorTestBase extends FunctionalTestBase {

  /**
   * Display returned by the last execution of the command.
   */
  protected string $display;

  /**
   * A directory to look up for fixtures.
   */
  protected string $fixtureDir;

  /**
   * Executes the command.
   *
   * @psalm-param class-string $command_class
   *   A command class to instantiate generator.
   * @psalm-param list<string> $user_input
   *   An array of strings representing each input passed to the command input
   *   stream.
   *
   * @psalm-return int<0, 1>
   */
  protected function execute(string $command_class, array $user_input): int {

    $application = self::createApplication();
    $command = $application
      ->getContainer()
      ->get('class_resolver')
      ->getInstanceFromDefinition($command_class);

    \assert($command instanceof Command);
    $application->add($command);

    $command_tester = new CommandTester($command);
    /** @psalm-var int<0, 1> $result */
    $result = $command_tester
      ->setInputs($user_input)
      ->execute(['--destination' => $this->directory]);

    $this->display = $command_tester->getDisplay();

    return $result;
  }

  /**
   * Asserts generated display.
   */
  protected function assertDisplay(string $expected_display): void {
    self::assertEquals($expected_display . \PHP_EOL, $this->display);
  }

  /**
   * Asserts generated file.
   */
  protected function assertGeneratedFile(string $file, ?string $fixture = NULL): void {
    // Fixture name typically is the same as the generated file name.
    $fixture ??= $file;
    self::assertFileEquals($this->fixtureDir . '/' . $fixture, $this->directory . '/' . $file);
  }

  /**
   * Asserts generated file.
   */
  protected function assertGeneratedDirectory(string $directory): void {
    self::assertDirectoryExists($this->directory . '/' . $directory);
  }

  /**
   * Returns contents of the generated file.
   */
  protected function getGeneratedContent(string $file): string {
    return \file_get_contents($this->directory . '/' . $file);
  }

}
