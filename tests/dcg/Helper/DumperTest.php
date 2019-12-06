<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\Dumper;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\Style\GeneratorStyle;
use DrupalCodeGenerator\Tests\BaseTestCase;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Filesystem\Filesystem;

/**
 * A test for Dumper helper.
 */
class DumperTest extends BaseTestCase {

  /**
   * Console input.
   *
   * @var \Symfony\Component\Console\Input\ArrayInput
   */
  protected $input;

  /**
   * Console output.
   *
   * @var \Symfony\Component\Console\Output\BufferedOutput
   */
  protected $output;

  /**
   * The file system component.
   *
   * @var \Symfony\Component\Filesystem\Filesystem
   */
  protected $filesystem;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $this->input = new ArrayInput([]);
    $this->output = new BufferedOutput();
    $this->filesystem = new Filesystem();
  }

  /**
   * Test callback.
   */
  public function testDumper(): void {

    // -- Default case.
    $assets = new AssetCollection();
    $assets[] = (new File('alpha.txt'))->content('alpha');
    $assets[] = (new File('beta.txt'))->content('beta');
    $assets[] = (new File('gamma.txt'))->content('gamma');
    $dumped_assets = $this->dump($assets);

    self::assertEquals($assets, $dumped_assets);
    $this->assertFiles($dumped_assets);
    self::assertOutput('');

    // -- File exists and user confirms replacing (default action).
    $this->filesystem->dumpFile($this->directory . '/foo.txt', 'old foo');
    $this->createFile('foo.txt');
    $assets = new AssetCollection();
    $assets[] = (new File('foo.txt'))->content('foo');
    $this->setStream("\n");

    $dumped_assets = $this->dump($assets);
    self::assertEquals($assets, $dumped_assets);
    $this->assertFiles($dumped_assets);
    $expected_output = "\n";
    $expected_output .= " The file {dir}/foo.txt already exists. Would you like to replace it? [Yes]:\n";
    $expected_output .= " ➤ ";
    $expected_output = str_replace('{dir}', $this->directory, $expected_output);
    self::assertOutput($expected_output);

    // -- File exists and user confirms replacing.
    $this->createFile('bar.txt');
    $assets = new AssetCollection();
    $assets[] = (new File('bar.txt'))->content('bar');
    $this->setStream("Yes\n");
    $dumped_assets = $this->dump($assets);

    self::assertEquals($assets, $dumped_assets);
    $this->assertFiles($dumped_assets);
    $expected_output = "\n";
    $expected_output .= " The file {dir}/bar.txt already exists. Would you like to replace it? [Yes]:\n";
    $expected_output .= " ➤ ";
    self::assertOutput($expected_output);

    // -- File exists and user cancels replacing.
    $this->createFile('example.txt');
    $assets = new AssetCollection();
    $assets[] = (new File('example.txt'))->content('example');
    $this->setStream("No\n");
    $dumped_assets = $this->dump($assets);

    self::assertEquals(new AssetCollection(), $dumped_assets);
    $this->assertFiles($dumped_assets);
    $expected_output = "\n";
    $expected_output .= " The file {dir}/example.txt already exists. Would you like to replace it? [Yes]:\n";
    $expected_output .= " ➤ ";
    self::assertOutput($expected_output);

    // -- Dumper with enabled replace option (always yes).
    $this->createFile('wine.txt');
    $assets = new AssetCollection();
    $assets[] = (new File('wine.txt'))->content('wine');
    $dumped_assets = $this->dump($assets, TRUE);

    self::assertEquals($assets, $dumped_assets);
    $this->assertFiles($dumped_assets);
    self::assertOutput('');

    // -- Dumper with enabled replace option (always no).
    $this->createFile('beer.txt');
    $assets = new AssetCollection();
    $assets[] = (new File('beer.txt'))->content('beer');
    $dumped_assets = $this->dump($assets, FALSE);

    self::assertEquals(new AssetCollection(), $dumped_assets);
    $this->assertFiles($dumped_assets);
    self::assertOutput('');

    // -- File with special permissions.
    $assets = new AssetCollection();
    $assets[] = (new File('prize.txt'))->content('prize')->mode(0757);
    $dumped_assets = $this->dump($assets);

    self::assertEquals($assets, $dumped_assets);
    $this->assertFiles($dumped_assets);
    self::assertOutput('');
    $permissions = decoct(fileperms($this->directory . '/prize.txt'));
    self::assertEquals($permissions, '100757');

    // -- Directory.
    $assets = new AssetCollection();
    $assets[] = new Directory('includes');
    $dumped_assets = $this->dump($assets);

    self::assertEquals($assets, $dumped_assets);
    self::assertDirectoryExists($this->directory . '/includes');
    self::assertOutput('');

    // -- Existing directory.
    $this->filesystem->dumpFile($this->directory . '/core/readme.txt', 'old readme');
    $assets = new AssetCollection();
    $assets[] = new Directory('core');
    $dumped_assets = $this->dump($assets);

    self::assertEquals(new AssetCollection(), $dumped_assets);
    self::assertDirectoryExists($this->directory . '/core');
    // Make sure that files in the directory have not been overwritten.
    static::assertFileExists($this->directory . '/core/readme.txt');
    self::assertOutput('');

    // -- Append file content.
    $this->filesystem->dumpFile($this->directory . '/log.txt', "File header");

    $assets = new AssetCollection();
    $assets[] = (new File('log.txt'))->content("redundant line\nRecord 1")->appendIfExists()->headerSize(1);
    $assets[] = (new File('log.txt'))->content('Record 2')->appendIfExists();
    $dumped_assets = $this->dump($assets, TRUE);

    self::assertEquals($assets, $dumped_assets);
    $content = "File header\nRecord 1\nRecord 2";
    self::assertStringEqualsFile($this->directory . '/log.txt', $content);
    self::assertOutput('');

    // -- Dry dump.
    $assets = new AssetCollection();
    $assets[] = (new File('example.txt'))->content('Example');
    $assets[] = new Directory('foo');
    $dumped_assets = $this->dump($assets, NULL, TRUE);

    self::assertEquals(new AssetCollection(), $dumped_assets);
    $expected_output = "\n";
    $expected_output .= " /tmp/dcg_sandbox/foo (empty directory)\n";
    $expected_output .= "––––––––––––––––––––––––––––––––––––––––\n";
    $expected_output .= "\n";
    $expected_output .= " /tmp/dcg_sandbox/example.txt\n";
    $expected_output .= "––––––––––––––––––––––––––––––\n";
    $expected_output .= "Example\n";
    self::assertOutput($expected_output);
  }

  /**
   * Asserts dumper output.
   */
  protected function assertOutput(string $expected_output): void {
    $expected_output = str_replace('{dir}', $this->directory, $expected_output);
    static::assertEquals($expected_output, $this->output->fetch());
  }

  /**
   * Asserts contents of dumped assets.
   */
  protected function assertFiles(AssetCollection $assets): void {
    foreach ($assets as $asset) {
      static::assertStringEqualsFile($this->directory . '/' . $asset->getPath(), $asset->getContent());
    }
  }

  /**
   * Dumps assets into file system.
   */
  protected function dump(AssetCollection $assets, ?bool $replace = NULL, bool $dry_run = FALSE): AssetCollection {
    $question_helper = new QuestionHelper();
    $helper_set = new HelperSet();
    $helper_set->set(new QuestionHelper());
    $io = new GeneratorStyle($this->input, $this->output, $question_helper);
    $dumper = new Dumper($this->filesystem, $replace);
    $dumper->io($io);
    $dumper->setHelperSet($helper_set);
    return $dumper->dump($assets, $this->directory, $dry_run);
  }

  /**
   * Sets the input stream to read from when interacting with the user.
   *
   * @param string $input
   *   Input that is to be written.
   */
  protected function setStream(string $input): void {
    $stream = fopen('php://memory', 'r+', FALSE);
    fwrite($stream, $input);
    rewind($stream);
    $this->input->setStream($stream);
  }

  /**
   * Creates a file.
   */
  protected function createFile(string $file_name): void {
    $this->filesystem->dumpFile($this->directory . '/' . $file_name, mt_rand());
  }

}
