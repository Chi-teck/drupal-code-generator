<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Helper\Dumper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Helper\Dumper\DryDumper;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\InputOutput\IO;
use DrupalCodeGenerator\Tests\Unit\BaseTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Filesystem\Filesystem;

/**
 * A test for DryDumper helper.
 */
final class DryDumperTest extends BaseTestCase {

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
  protected function setUp(): void {
    parent::setUp();
    $definition[] = new InputOption('full-path', NULL, InputOption::VALUE_NONE);
    $this->input = new ArrayInput([], new InputDefinition($definition));
    $this->output = new BufferedOutput();
    $this->filesystem = new Filesystem();
  }

  /**
   * Test callback.
   */
  public function testDryDump(): void {

    $assets = new AssetCollection();
    $assets[] = Directory::create('foo');
    $assets[] = File::create('example.txt')->content('Example');
    $assets[] = Symlink::create('foo.link', 'example.txt');

    $dumped_assets = $this->createDumper()->dump($assets, $this->directory);
    self::assertEquals($assets, $dumped_assets);

    $dir_content = \scandir($this->directory);
    self::assertSame(['.', '..'], $dir_content);

    $expected_output = <<< 'TEXT'

     foo (empty directory)
    –––––––––––––––––––––––

     example.txt
    –––––––––––––
    Example

     foo.link
    ––––––––––
    Symlink to example.txt

    TEXT;
    self::assertSame($expected_output, $this->output->fetch());
  }

  /**
   * Creates dumper.
   */
  private function createDumper(): DryDumper {
    $question_helper = new QuestionHelper();
    $io = new IO($this->input, $this->output, $question_helper);
    $dumper = new DryDumper($this->filesystem);
    $dumper->io($io);
    return $dumper;
  }

}
