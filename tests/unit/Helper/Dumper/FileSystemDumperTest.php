<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Helper\Dumper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Helper\Dumper\FileSystemDumper;
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
 * A test for FileSystemDumper helper.
 */
final class FileSystemDumperTest extends BaseTestCase {

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
    $definition[] = new InputOption('dry-run', NULL, InputOption::VALUE_NONE);
    $definition[] = new InputOption('replace', NULL, InputOption::VALUE_NONE);
    $this->input = new ArrayInput([], new InputDefinition($definition));
    $this->output = new BufferedOutput();
    $this->filesystem = new Filesystem();
  }

  /**
   * Test callback.
   */
  public function testWithoutExistingFiles(): void {
    $assets = new AssetCollection();
    $assets[] = File::create('alpha.txt')->content('alpha');
    $assets[] = File::create('beta.txt')->content('beta');
    $assets[] = File::create('gamma.txt')->content('gamma');

    $dumped_assets = $this->dump($assets);
    self::assertEquals($assets, $dumped_assets);

    $expected_content = [
      'alpha.txt' => 'alpha',
      'beta.txt' => 'beta',
      'gamma.txt' => 'gamma',
    ];
    $this->assertContent($expected_content);

    $this->assertEmptyOutput();
  }

  /**
   * Test callback.
   */
  public function testUserImplicitlyConfirmsReplacing(): void {
    $this->createFile('foo.txt');

    $assets = new AssetCollection();
    $assets[] = File::create('foo.txt')->content('foo');

    $this->setStream("\n");
    $dumped_assets = $this->dump($assets);
    self::assertEquals($assets, $dumped_assets);

    $expected_content = [
      'foo.txt' => 'foo',
    ];
    $this->assertContent($expected_content);

    $expected_output = <<< TEXT

     The file {$this->directory}/foo.txt already exists. Would you like to replace it? [Yes]:
     ➤ 
    TEXT;
    self::assertSame($expected_output, $this->output->fetch());
  }

  /**
   * Test callback.
   */
  public function testUserConfirmsReplacing(): void {
    $this->createFile('bar.txt');

    $assets = new AssetCollection();
    $assets[] = File::create('bar.txt')->content('bar');

    $this->setStream("Yes\n");
    $dumped_assets = $this->dump($assets);
    self::assertEquals($assets, $dumped_assets);

    $expected_content = [
      'bar.txt' => 'bar',
    ];
    $this->assertContent($expected_content);

    $expected_output = <<< TEXT

     The file {$this->directory}/bar.txt already exists. Would you like to replace it? [Yes]:
     ➤ 
    TEXT;
    self::assertSame($expected_output, $this->output->fetch());
  }

  /**
   * Test callback.
   */
  public function testUserCancelsReplacing(): void {
    $this->createFile('example.txt', 'Example');

    $assets = new AssetCollection();
    $assets[] = File::create('example.txt')->content('example');

    $this->setStream("No\n");
    $dumped_assets = $this->dump($assets);
    self::assertEquals(new AssetCollection(), $dumped_assets);

    $expected_content = [
      'example.txt' => 'Example',
    ];
    $this->assertContent($expected_content);

    $expected_output = <<< TEXT

     The file {$this->directory}/example.txt already exists. Would you like to replace it? [Yes]:
     ➤ 
    TEXT;
    self::assertSame($expected_output, $this->output->fetch());
  }

  /**
   * Test callback.
   */
  public function testReplaceOptionYes(): void {
    $this->createFile('wine.txt');

    $assets = new AssetCollection();
    $assets[] = File::create('wine.txt')->content('Wine');

    $this->input->setOption('replace', TRUE);
    $dumped_assets = $this->dump($assets);
    self::assertEquals($assets, $dumped_assets);

    $expected_content = [
      'wine.txt' => 'Wine',
    ];
    $this->assertContent($expected_content);

    $this->assertEmptyOutput();
  }

  /**
   * Test callback.
   */
  public function testFilePermissions(): void {
    $assets = new AssetCollection();
    $assets[] = File::create('prize.txt')->content('Prize')->mode(0757);

    $dumped_assets = $this->dump($assets);
    self::assertEquals($assets, $dumped_assets);

    $expected_content = [
      'prize.txt' => 'Prize',
    ];
    $this->assertContent($expected_content);

    $permissions = \decoct(\fileperms($this->directory . '/prize.txt'));
    self::assertSame($permissions, '100757');

    $this->assertEmptyOutput();
  }

  /**
   * Test callback.
   */
  public function testDirectory(): void {
    $assets = new AssetCollection();
    $assets[] = new Directory('includes');

    $dumped_assets = $this->dump($assets);
    self::assertEquals($assets, $dumped_assets);

    $expected_content = [
      'includes' => [],
    ];
    $this->assertContent($expected_content);

    $this->assertEmptyOutput();
  }

  /**
   * Test callback.
   */
  public function testPrependFile(): void {
    $this->createFile('log.txt', 'Record 1');

    $assets = new AssetCollection();
    $assets[] = File::create('log.txt')->content('File header')->prependIfExists();
    $dumped_assets = $this->dump($assets);
    $expected_assets = new AssetCollection();
    $expected_assets[] = File::create('log.txt')->content("File header\nRecord 1")->prependIfExists();
    self::assertEquals($expected_assets, $dumped_assets);

    $expected_content = [
      'log.txt' => "File header\nRecord 1",
    ];
    $this->assertContent($expected_content);

    $this->assertEmptyOutput();
  }

  /**
   * Test callback.
   *
   * @todo Clean-up.
   */
  public function testAppendFile(): void {
    $this->createFile('log.txt', 'File header');

    $assets = new AssetCollection();
    $assets[] = File::create('log.txt')
      ->content("redundant line\nRecord 1")
      ->appendIfExists(1);
    $assets[] = File::create('log.txt')
      ->content('Record 2')
      ->appendIfExists();

    $expected_assets = new AssetCollection();
    $expected_assets[] = File::create('log.txt')
      ->content("File header\nRecord 1")
      ->appendIfExists(1);
    $expected_assets[] = File::create('log.txt')
      ->content("File header\nRecord 1\nRecord 2")
      ->appendIfExists();

    $dumped_assets = $this->dump($assets);
    self::assertEquals($expected_assets, $dumped_assets);

    $expected_content = [
      'log.txt' => "File header\nRecord 1\nRecord 2",
    ];
    $this->assertContent($expected_content);

    $this->assertEmptyOutput();
  }

  /**
   * Test callback.
   */
  public function testSkipFile(): void {
    $this->createFile('log.txt', 'Existing record');

    $assets = new AssetCollection();
    $assets[] = File::create('log.txt')->content('New Record')->preserveIfExists();

    $dumped_assets = $this->dump($assets);
    self::assertEquals(new AssetCollection(), $dumped_assets);

    $expected_content = [
      'log.txt' => 'Existing record',
    ];
    $this->assertContent($expected_content);

    $this->assertEmptyOutput();
  }

  /**
   * Test callback.
   */
  public function testSymlink(): void {
    $assets = new AssetCollection();
    $assets[] = Directory::create('Alpha/Beta/Gamma');
    $assets[] = File::create('foo.txt')->content('Bar');
    $assets[] = Symlink::create('foo.link', 'foo.txt');
    $assets[] = Symlink::create('abg.link', 'Alpha/Beta/Gamma');

    $dumped_assets = $this->dump($assets);
    self::assertEquals($assets, $dumped_assets);

    $expected_content = [
      'Alpha/Beta/Gamma' => [],
      'Alpha/Beta' => [],
      'Alpha' => [],
      'abg.link (Alpha/Beta/Gamma)' => [],
      'foo.link (foo.txt)' => 'Bar',
      'foo.txt' => 'Bar',
    ];
    $this->assertContent($expected_content);

    $this->assertEmptyOutput();
  }

  /**
   * Test callback.
   */
  public function testSymlinkAndExistingFile(): void {
    $this->createFile('foo.link', 'Existing content');

    $assets = new AssetCollection();
    $assets[] = Symlink::create('foo.link', 'foo.txt')->preserveIfExists();

    $dumped_assets = $this->dump($assets);
    self::assertEquals(new AssetCollection(), $dumped_assets);

    $expected_content = [
      'foo.link' => 'Existing content',
    ];
    $this->assertContent($expected_content);

    $this->assertEmptyOutput();
  }

  /**
   * Asserts empty dumper output.
   */
  private function assertEmptyOutput(): void {
    self::assertSame('', $this->output->fetch());
  }

  /**
   * Asserts content.
   */
  private function assertContent(array $content): void {
    self::assertSame($content, $this->readAssets($this->directory));
  }

  /**
   * Dumps assets into file system.
   */
  private function dump(AssetCollection $assets): AssetCollection {
    $question_helper = new QuestionHelper();
    $helper_set = new HelperSet();
    $helper_set->set(new QuestionHelper());

    $io = new IO($this->input, $this->output, $question_helper);

    $dumper = new FileSystemDumper($this->filesystem);
    $dumper->io($io);
    $dumper->setHelperSet($helper_set);

    return $dumper->dump($assets, $this->directory);
  }

  /**
   * Sets the input stream to read from when interacting with the user.
   *
   * @param string $input
   *   Input that is to be written.
   */
  private function setStream(string $input): void {
    $stream = \fopen('php://memory', 'r+', FALSE);
    \fwrite($stream, $input);
    \rewind($stream);
    $this->input->setStream($stream);
  }

  /**
   * Creates a file.
   */
  private function createFile(string $file_name, string $content = ''): void {
    $this->filesystem->dumpFile($this->directory . '/' . $file_name, $content);
  }

  /**
   * Recursively read assets.
   */
  private function readAssets(string $directory): array {
    $results = [];
    foreach (\scandir($directory) as $file) {
      if ($file !== '.' && $file !== '..') {
        $path = $directory . \DIRECTORY_SEPARATOR . $file;
        $relative_path = \rtrim($this->filesystem->makePathRelative($path, $this->directory), '/');
        if (\is_link($path)) {
          $relative_path .= ' (' . \readlink($path) . ')';
        }
        if (\is_dir($path)) {
          $results += self::readAssets($path);
          $results[$relative_path] = [];
        }
        else {
          $results[$relative_path] = \file_get_contents($path);
        }
      }
    }
    return $results;
  }

}
