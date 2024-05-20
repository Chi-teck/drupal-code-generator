<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Asset\Resolver;

use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\InputOutput\IO;
use DrupalCodeGenerator\Tests\Unit\BaseTestCase;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Base class for resolver tests.
 */
abstract class BaseResolver extends BaseTestCase {

  /**
   * Console input.
   */
  protected ArrayInput $input;

  /**
   * Console output.
   */
  private BufferedOutput $output;

  /**
   * The file system component.
   */
  private Filesystem $filesystem;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $definition[] = new InputOption('replace', NULL, InputOption::VALUE_NONE);
    $definition[] = new InputOption('dry-run', NULL, InputOption::VALUE_NONE);
    $this->input = new ArrayInput([], new InputDefinition($definition));
    $this->setStream('');
    $this->output = new BufferedOutput();
    $this->filesystem = new Filesystem();
  }

  final protected function createGeneratorStyle(): IO {
    $question_helper = new QuestionHelper();
    $helper_set = new HelperSet();
    $helper_set->set($question_helper);
    return new IO($this->input, $this->output, $question_helper);
  }

  final protected function assertOutput(string $expected_output): void {
    $expected_output = \str_replace('%directory%', $this->directory, $expected_output);
    self::assertSame($expected_output, $this->output->fetch());
  }

  final protected function assertEmptyOutput(): void {
    self::assertSame('', $this->output->fetch());
  }

  /**
   * Sets the input stream to read from when interacting with the user.
   *
   * @param string $input
   *   Input that is to be written.
   */
  final protected function setStream(string $input): void {
    $stream = \fopen('php://memory', 'r+', FALSE);
    \fwrite($stream, $input);
    \rewind($stream);
    $this->input->setStream($stream);
  }

  /**
   * Creates a file.
   */
  final protected function createFile(string $name, string $content = ''): string {
    $path = $this->directory . '/' . $name;
    $this->filesystem->dumpFile($path, $content);
    return $path;
  }

}
