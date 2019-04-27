<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Asset;
use DrupalCodeGenerator\Command\GeneratorInterface;
use DrupalCodeGenerator\Helper\Dumper;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\Tests\BaseTestCase;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Filesystem\Filesystem;

/**
 * A test for dumper helper.
 */
class DumperTest extends BaseTestCase {

  /**
   * The input.
   *
   * @var \Symfony\Component\Console\Input\ArrayInput
   */
  protected $input;

  /**
   * The output.
   *
   * @var \Symfony\Component\Console\Output\BufferedOutput
   */
  protected $output;

  /**
   * Helper set.
   *
   * @var \Symfony\Component\Console\Helper\HelperSet
   */
  protected $helperSet;

  /**
   * The dumper.
   *
   * @var \DrupalCodeGenerator\Helper\Dumper
   */
  protected $dumper;

  /**
   * Files to dump.
   *
   * @var array
   */
  protected $assets = [];

  /**
   * {@inheritdoc}
   */
  public function setUp() {

    parent::setUp();

    $this->input = new ArrayInput([], new InputDefinition());

    $this->output = new BufferedOutput();

    $command = $this->createMock(GeneratorInterface::class);
    $command
      ->method('getDirectory')
      ->willReturn($this->directory);
    $command
      ->method('getAssets')
      ->will(static::returnCallback(function () {
        return $this->assets;
      }));

    $this->helperSet = $this->createMock(HelperSet::class);
    $this->helperSet->method('getCommand')
      ->willReturn($command);
    $this->helperSet->method('get')
      ->willReturn(new QuestionHelper());

    $this->setDumper();
  }

  /**
   * Test callback.
   */
  public function testDumper() {

    $question_text = 'The file {DIR}/foo.txt already exists. Would you like to replace it?';

    // -- Default case.
    $this->assets = [
      static::createAsset('foo.txt', __LINE__),
      static::createAsset('bar.txt', __LINE__),
      static::createAsset('dir_1/dir_2/dir_3/baz.txt', __LINE__),
    ];
    $results = $this->dump();
    $this->assertResults($results);
    $this->assertFileContents();
    $this->assertOutput('');

    // -- File exists and user confirms replacing (default action).
    $this->setStream("\n");
    $this->files = ['foo.txt' => __LINE__];
    $this->assets = [
      static::createAsset('foo.txt', __LINE__),
    ];
    $results = $this->dump();
    $this->assertResults($results);
    $this->assertFileContents();
    $this->assertOutput("\n $question_text [Yes]:\n ➤ ");

    // -- File exists and user confirms replacing.
    $this->setStream("Yes\n");
    $this->assets = [
      static::createAsset('foo.txt', $expected_content = __LINE__),
    ];
    $results = $this->dump();
    $this->assertResults($results);
    $this->assertFileContents();
    $this->assertOutput("\n $question_text [Yes]:\n ➤ ");

    // -- File exists and user cancels replacing.
    $this->setStream("Not\n");
    $this->assets = [
      static::createAsset('foo.txt', __LINE__),
    ];
    $results = $this->dump();
    $this->assertEmptyResults($results);
    $this->assertFileContents([static::createAsset('foo.txt', $expected_content)]);
    $this->assertOutput("\n $question_text [Yes]:\n ➤ ");

    // -- Dumper with enabled replace option (always yes).
    $this->setDumper(TRUE);
    $this->assets = [
      static::createAsset('foo.txt', $expected_content = __LINE__),
    ];
    $results = $this->dump();
    $this->assertResults($results);
    $this->assertFileContents();
    $this->assertOutput('');

    // -- Dumper with enabled replace option (always not).
    $this->setDumper(FALSE);
    $this->assets = [
      static::createAsset('foo.txt', __LINE__),
    ];
    $results = $this->dump();
    $this->assertEmptyResults($results);
    $this->assertFileContents([static::createAsset('foo.txt', $expected_content)]);
    $this->assertOutput('');

    // -- File with special permissions.
    $this->assets = [
      static::createAsset('hi.txt', 'Hello world')->mode(0757),
    ];
    $results = $this->dump();
    $this->assertResults($results);
    $this->assertFileContents();
    $this->assertOutput('');
    $permissions = decoct(fileperms($this->directory . '/hi.txt'));
    static::assertEquals($permissions, '100757');

    // -- Directory.
    $this->setDumper();
    $this->assets = [
      static::createAsset('example')->type('directory'),
    ];
    $results = $this->dump();
    $this->assertResults($results);
    static::assertTrue(is_dir($this->directory . '/example'));
    $this->assertOutput('');

    // -- Existing directory.
    $this->assets = [
      static::createAsset('foo/bar.txt', $expected_content = __LINE__),
    ];
    $this->dump();
    $this->assets = [
      static::createAsset('foo')->type('directory'),
    ];
    $results = $this->dump();
    $this->assertResults($results);
    // Make sure that files in the directory have not been overwritten.
    $this->assertFileContents([static::createAsset('foo/bar.txt', $expected_content)]);
    static::assertTrue(is_dir($this->directory . '/example'));
    $this->assertOutput('');

    // -- Append file content.
    $this->assets = [
      static::createAsset('example.txt', "Line 1\n"),
    ];
    $this->dump();
    $this->assets = [
      static::createAsset('example.txt', "Line 2\n")->action('append'),
    ];
    $this->dump();
    $this->assets = [
      static::createAsset('example.txt', "Header\nLine 3\n")->action('append')->headerSize(1),
    ];
    $results = $this->dump();
    $this->assertResults($results);
    $this->assertFileContents([static::createAsset('example.txt', "Line 1\n\nLine 2\n\nLine 3\n")]);
    $this->assertOutput('');
  }

  /**
   * Asserts that provided results matches defined files.
   *
   * @param array $expected_results
   *   List of dumped files.
   */
  protected function assertResults(array $expected_results) {
    $files = [];
    foreach ($this->assets as $asset) {
      $files[] = $asset->getPath();
    }
    static::assertEquals($files, $expected_results);
  }

  /**
   * Asserts that provided results are empty.
   *
   * @param array $expected_results
   *   List of dumped files.
   */
  protected function assertEmptyResults(array $expected_results) {
    static::assertEquals([], $expected_results);
  }

  /**
   * Asserts dumper output.
   *
   * @param string $expected_output
   *   Expected dumper output.
   */
  protected function assertOutput($expected_output) {
    $expected_output = str_replace('{DIR}', $this->directory, $expected_output);
    static::assertEquals($expected_output, $this->output->fetch());
  }

  /**
   * Asserts contents of dumped assets.
   *
   * @param \DrupalCodeGenerator\Asset[] $assets
   *   (Optional) Assets to check.
   */
  protected function assertFileContents(array $assets = NULL) {
    foreach ($assets ?: $this->assets as $asset) {
      static::assertStringEqualsFile($this->directory . '/' . $asset->getPath(), $asset->getContent());
    }
  }

  /**
   * Dumps files into file system.
   *
   * @return array
   *   List of created or updated files.
   */
  protected function dump() {
    return $this->dumper->dump($this->input, $this->output);
  }

  /**
   * Sets the input stream to read from when interacting with the user.
   *
   * @param string $input
   *   Input that is to be written.
   */
  protected function setStream($input) {
    $stream = fopen('php://memory', 'r+', FALSE);
    fwrite($stream, $input);
    rewind($stream);
    $this->input->setStream($stream);
  }

  /**
   * Sets new dumper instance.
   *
   * @param bool $replace
   *   (optional) Indicates weather or not existing files can be replaced.
   */
  protected function setDumper($replace = NULL) {
    $this->dumper = new Dumper(new Filesystem(), $replace);
    $this->dumper->setHelperSet($this->helperSet);
  }

  /**
   * Creates an asset.
   *
   * @param string $path
   *   Asset path.
   * @param string $content
   *   (optional) Asset content.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  protected static function createAsset($path, $content = NULL) {
    return (new Asset())->path($path)->content($content);
  }

}
