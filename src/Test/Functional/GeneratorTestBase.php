<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Test\Functional;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Base class for generator tests.
 */
abstract class GeneratorTestBase extends FunctionalTestBase {

  protected string $display;
  protected string $fixtureDir;
  private string $directory;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->directory = \sys_get_temp_dir() . '/dcg_sandbox';
  }

  /**
   * {@inheritdoc}
   */
  protected function tearDown(): void {
    parent::tearDown();
    (new Filesystem())->remove($this->directory);
  }

  /**
   * Executes the command.
   *
   * @param string $command_class
   *   A command class to instantiate generator.
   * @param array $user_input
   *   An array of strings representing each input passed to the command input
   *   stream.
   */
  protected function execute(string $command_class, array $user_input): int {

    $command = $this->application
      ->getContainer()
      ->get('class_resolver')
      ->getInstanceFromDefinition($command_class);

    $this->application->add($command);

    $command_tester = new CommandTester($command);
    $result = $command_tester
      ->setInputs(\array_values($user_input))
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
