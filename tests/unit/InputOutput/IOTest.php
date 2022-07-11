<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\InputOutput;

use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\InputOutput\IO;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputOption as Option;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * A test for Input/Output helper.
 */
final class IOTest extends TestCase {

  private readonly IO $io;

  protected function setUp(): void {
    parent::setUp();
    $definition[] = new InputOption('working-dir', 'd', Option::VALUE_OPTIONAL, 'Working directory');
    $this->io = new IO(
      new ArrayInput([], new InputDefinition($definition)),
      new BufferedOutput(decorated: TRUE),
      new QuestionHelper(),
    );
  }

  /**
   * Test callback.
   */
  public function testTitle(): void {
    $this->io->title('Example');
    $expected_display = <<< 'TXT'

       Example
      [36;1m–––––––––[39;22m

      TXT;
    $this->assertDisplay($expected_display);
  }

  /**
   * Test callback.
   */
  public function testAskQuestion(): void {
    $this->setStream('12:00');
    $question = new Question('What time is it?');
    $this->io->askQuestion($question);
    $expected_display = <<< 'TXT'

       [32mWhat time is it?[39m
       ➤ 
      TXT;
    $this->assertDisplay($expected_display);
  }

  /**
   * Test callback.
   */
  public function testListing(): void {
    $items = ['Alpha', 'Beta', 'Gamma'];
    $this->io->listing($items);
    $expected_display = <<< 'TXT'
       • Alpha
       • Beta
       • Gamma


      TXT;
    $this->assertDisplay($expected_display);
  }

  /**
   * Test callback.
   */
  public function testBuildTable(): void {
    $headers = ['Alpha', 'Beta', 'Gamma'];
    $rows = [
      ['a', 'b', 'c'],
      ['d', 'e', 'f'],
    ];
    $this->io->buildTable($headers, $rows)->render();
    $expected_display = <<< 'TXT'
       ------- ------ ------- 
       [32m Alpha [39m [32m Beta [39m [32m Gamma [39m 
       ------- ------ ------- 
        a       b      c      
        d       e      f      
       ------- ------ ------- 

      TXT;
    $this->assertDisplay($expected_display);
  }

  /**
   * Test callback.
   */
  public function testGetInput(): void {
    self::assertInstanceOf(InputInterface::class, $this->io->getInput());
  }

  /**
   * Test callback.
   */
  public function testGetOutput(): void {
    self::assertInstanceOf(OutputInterface::class, $this->io->getOutput());
  }

  /**
   * Test callback.
   */
  public function testGetErrorStyle(): void {
    self::assertInstanceOf(IO::class, $this->io->getErrorStyle());
  }

  /**
   * Test callback.
   */
  public function testGetWorkingDirectory(): void {
    self::assertSame(\getcwd(), $this->io->getWorkingDirectory());

    $pwd = $_SERVER['PWD'];
    $_SERVER['PWD'] = '/tmp/foo';
    self::assertSame('/tmp/foo', $this->io->getWorkingDirectory());
    $_SERVER['PWD'] = $pwd;

    $this->io->getInput()->setOption('working-dir', '/tmp/bar');
    self::assertSame('/tmp/bar', $this->io->getWorkingDirectory());
  }

  /**
   * Asserts display.
   */
  private function assertDisplay(string $expected_display): void {
    self::assertSame($expected_display, $this->io->getOutput()->fetch());
  }

  /**
   * Sets the input stream to read from when interacting with the user.
   */
  private function setStream(string $input): void {
    $stream = \fopen('php://memory', 'r+', FALSE);
    \fwrite($stream, $input);
    \rewind($stream);
    $this->io->getInput()->setStream($stream);
  }

}
