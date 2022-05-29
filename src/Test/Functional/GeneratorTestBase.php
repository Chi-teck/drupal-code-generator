<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Test\Functional;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Command\Command;
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
  public function setUp(): void {
    parent::setUp();
    $this->directory = \sys_get_temp_dir() . '/dcg_sandbox';
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown(): void {
    parent::tearDown();
    (new Filesystem())->remove($this->directory);
  }

  /**
   * Executes the command.
   *
   * @param \Symfony\Component\Console\Command\Command $command
   *   A command to execute.
   * @param array $user_input
   *   An array of strings representing each input passed to the command input
   *   stream.
   */
  protected function execute(Command $command, array $user_input): int {
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
    $default_name = \basename(\getcwd());
    $expected_display = \str_replace('%default_name%', $default_name, $expected_display) . \PHP_EOL;
    // @todo Do not provide default value for the human name.
    $default_human_name = Utils::machine2human($default_name);
    $expected_display = \str_replace('%default_human_name%', $default_human_name, $expected_display);
    self::assertEquals($expected_display, $this->display);
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
