<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Command\GeneratorInterface;
use DrupalCodeGenerator\Helper\Dumper;
use DrupalCodeGenerator\Tests\WorkingDirectoryTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Filesystem\Filesystem;

/**
 * A test for dumper helper.
 */
class DumperTest extends TestCase {

  use WorkingDirectoryTrait;

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
  protected $files = [];

  /**
   * {@inheritdoc}
   */
  public function setUp() {

    $this->initWorkingDirectory();

    $this->input = new ArrayInput([], new InputDefinition());
    $this->output = new BufferedOutput();

    $command = $this->createMock(GeneratorInterface::class);
    $command
      ->method('getDirectory')
      ->willReturn($this->directory);
    $command
      ->method('getFiles')
      ->will($this->returnCallback(function () {
        return $this->files;
      }));

    $this->helperSet = $this->createMock(HelperSet::class);
    $this->helperSet->method('getCommand')
      ->willReturn($command);
    $this->helperSet->method('get')
      ->willReturn(new QuestionHelper());

    $this->setDumper();
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    $this->removeWorkingDirectory();
  }

  /**
   * Test callback.
   *
   * @covers \DrupalCodeGenerator\Helper\Dumper::dump()
   */
  public function testDumper() {

    // -- Default case.
    $this->files = [
      'foo.txt' => __LINE__,
      'bar.txt' => __LINE__,
      'dir_1/dir_2/dir_3/baz.txt' => __LINE__,
    ];
    $results = $this->dump();
    $this->assertResults($results);
    $this->assertFileContents();
    $this->assertOutput('');

    // -- File exists and user confirms replacing (default action).
    $this->setStream("\n");
    $this->files = ['foo.txt' => __LINE__];
    $results = $this->dump();
    $this->assertResults($results);
    $this->assertFileContents();
    $this->assertOutput('The file {DIR}/foo.txt already exists. Would you like to replace it? [Yes]: ');

    // -- File exists and user confirms replacing.
    $this->setStream("Yes\n");
    $this->files = ['foo.txt' => $expected_content = __LINE__];
    $results = $this->dump();
    $this->assertResults($results);
    $this->assertFileContents();
    $this->assertOutput('The file {DIR}/foo.txt already exists. Would you like to replace it? [Yes]: ');

    // -- File exists and user cancels replacing.
    $this->setStream("Not\n");
    $this->files = ['foo.txt' => __LINE__];
    $results = $this->dump();
    $this->assertEmptyResults($results);
    $this->assertFileContents(['foo.txt' => $expected_content]);
    $this->assertOutput('The file {DIR}/foo.txt already exists. Would you like to replace it? [Yes]: ');

    // -- Dumper with enabled replace option (always yes).
    $this->setDumper(TRUE);
    $this->files = ['foo.txt' => $expected_content = __LINE__];
    $results = $this->dump();
    $this->assertResults($results);
    $this->assertFileContents();
    $this->assertOutput("The file {DIR}/foo.txt already exists. Would you like to replace it? [Yes]: Yes\n");

    // -- Dumper with enabled replace option (always not).
    $this->setDumper(FALSE);
    $this->files = ['foo.txt' => __LINE__];
    $results = $this->dump();
    $this->assertEmptyResults($results);
    $this->assertFileContents(['foo.txt' => $expected_content]);
    $this->assertOutput("The file {DIR}/foo.txt already exists. Would you like to replace it? [Yes]: No\n");

    // -- File with special permissions.
    $this->files = [
      'hi.txt' => [
        'content' => 'Hello world',
        'mode' => 0757,
      ],
    ];
    $results = $this->dump();
    $this->assertResults($results);
    $this->assertFileContents();
    $this->assertOutput('');
    $permissions = decoct(fileperms($this->directory . '/hi.txt'));
    $this->assertEquals($permissions, '100757');

    // -- Directory.
    $this->setDumper();
    $this->files = ['example' => NULL];
    $results = $this->dump();
    $this->assertResults($results);
    $this->assertTrue(is_dir($this->directory . '/example'));
    $this->assertOutput('');

    // -- Existing directory.
    $this->files = ['foo/bar.txt' => $expected_content = __LINE__];
    $this->dump();
    $this->files = ['foo' => NULL];
    $results = $this->dump();
    $this->assertResults($results);
    // Make sure that files in the directory have not been overwritten.
    $this->assertFileContents(['foo/bar.txt' => $expected_content]);
    $this->assertTrue(is_dir($this->directory . '/example'));
    $this->assertOutput('');

    // -- Append file content.
    $this->files = [
      'example.txt' => [
        'content' => "Line 1\n",
      ],
    ];
    $this->dump();
    $this->files = [
      'example.txt' => [
        'content' => "Line 2\n",
        'action' => 'append',
      ],
    ];
    $this->dump();
    $this->files = [
      'example.txt' => [
        'content' => "Header\nLine 3\n",
        'action' => 'append',
        'header_size' => 1,
      ],
    ];
    $results = $this->dump();
    $this->assertResults($results);
    $this->assertFileContents(['example.txt' => "Line 1\n\nLine 2\n\nLine 3\n"]);
    $this->assertOutput('');
  }

  /**
   * Asserts that provided results matches defined files.
   *
   * @param array $expected_results
   *   List of dumped files.
   */
  protected function assertResults(array $expected_results) {
    $this->assertEquals(array_keys($this->files), $expected_results);
  }

  /**
   * Asserts that provided results are empty.
   *
   * @param array $expected_results
   *   List of dumped files.
   */
  protected function assertEmptyResults(array $expected_results) {
    $this->assertEquals([], $expected_results);
  }

  /**
   * Asserts dumper output.
   *
   * @param string $expected_output
   *   Expected dumper output.
   */
  protected function assertOutput($expected_output) {
    $expected_output = str_replace('{DIR}', $this->directory, $expected_output);
    $this->assertEquals($expected_output, $this->output->fetch());
  }

  /**
   * Asserts contents of dumped files.
   *
   * @param array $files
   *   (Optional) Files to check.
   */
  protected function assertFileContents(array $files = NULL) {
    foreach ($files ?: $this->files as $file_name => $file_info) {
      $content = is_array($file_info) ? $file_info['content'] : $file_info;
      $this->assertStringEqualsFile($this->directory . '/' . $file_name, $content);
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

}
