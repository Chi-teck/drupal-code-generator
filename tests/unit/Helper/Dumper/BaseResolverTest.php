<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Helper\Dumper;

use DrupalCodeGenerator\Helper\Dumper\Resolver;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\Style\GeneratorStyle;
use DrupalCodeGenerator\Tests\Unit\BaseTestCase;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Base class for resolver tests.
 */
abstract class BaseResolverTest extends BaseTestCase {

  /**
   * Console input.
   */
  private ArrayInput $input;

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
    $this->input = new ArrayInput([]);
    $this->output = new BufferedOutput();
    $this->filesystem = new Filesystem();
  }

  protected function createResolver(?bool $replace, bool $dry_run): Resolver {
    $options = new DumperOptions($replace, $dry_run, TRUE);
    $io = $this->createGeneratorStyle();
    return new Resolver($options, $io);
  }

  protected function createGeneratorStyle(): GeneratorStyle {
    $question_helper = new QuestionHelper();
    $helper_set = new HelperSet();
    $helper_set->set(new QuestionHelper());
    return new GeneratorStyle($this->input, $this->output, $question_helper);
  }

  protected function assertOutput(string $expected_output): void {
    $expected_output = \str_replace('%directory%', $this->directory, $expected_output);
    self::assertSame($expected_output, $this->output->fetch());
  }

  protected function assertEmptyOutput(): void {
    self::assertSame('', $this->output->fetch());
  }

  /**
   * Sets the input stream to read from when interacting with the user.
   *
   * @param string $input
   *   Input that is to be written.
   */
  protected function setStream(string $input): void {
    $stream = \fopen('php://memory', 'r+', FALSE);
    \fwrite($stream, $input);
    \rewind($stream);
    $this->input->setStream($stream);
  }

  /**
   * Creates a directory.
   */
  protected function createDirectory(string $name): string {
    $path = $this->directory . '/' . $name;
    $this->filesystem->mkdir($path);
    return $path;
  }

  /**
   * Creates a file.
   */
  protected function createFile(string $name, string $content = ''): string {
    $path = $this->directory . '/' . $name;
    $this->filesystem->dumpFile($path, $content);
    return $path;
  }

  /**
   * Creates a symlink.
   */
  protected function createSymlink(string $name, string $target): string {
    $path = $this->directory . '/' . $name;
    $target_path = $this->directory . '/' . $target;
    $this->filesystem->dumpFile($target_path, 'Content');
    \symlink($target_path, $path);
    return $path;
  }

}
