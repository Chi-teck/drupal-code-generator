<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Test;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\Tests\QuestionHelper;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use DrupalCodeGenerator\Utils;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Loader\FilesystemLoader;

/**
 * Base class for generator tests.
 */
abstract class GeneratorTest extends TestCase {

  protected string $display;
  protected string $fixtureDir;
  private string $directory;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    $this->directory = \sys_get_temp_dir() . '/dcg_sandbox';
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown(): void {
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
    $this->createApplication()->add($command);

    $command_tester = new CommandTester($command);
    $result = $command_tester
      ->setInputs(\array_values($user_input))
      ->execute(['--destination' => $this->directory, '--working-dir' => $this->directory]);

    $this->display = $command_tester->getDisplay();

    return $result;
  }

  /**
   * Asserts generated display.
   */
  protected function assertDisplay(string $expected_display): void {
    $default_name = Utils::machine2human(\basename($this->directory), TRUE);
    $expected_display = \str_replace('%default_name%', $default_name, $expected_display);
    self::assertEquals($expected_display, $this->display);
  }

  /**
   * Asserts generated file.
   */
  protected function assertGeneratedFile(string $file, string $fixture): void {
    self::assertFileEquals($this->fixtureDir . '/' . $fixture, $this->directory . '/' . $file);
  }

  /**
   * Asserts generated file.
   */
  protected function assertGeneratedDirectory(string $directory): void {
    self::assertDirectoryExists($this->directory . '/' . $directory);
  }

  /**
   * Creates DCG application.
   */
  protected function createApplication(): Application {
    $application = Application::create();

    $helper_set = $application->getHelperSet();

    // Replace default question helper to ease parsing output.
    $helper_set->set(new QuestionHelper());

    // Replace default renderer to enable 'strict_variables' in tests.
    $twig_environment = new TwigEnvironment(new FilesystemLoader([Application::TEMPLATE_PATH]), ['strict_variables' => TRUE]);
    $helper_set->set(new Renderer($twig_environment));
    return $application;
  }

}
