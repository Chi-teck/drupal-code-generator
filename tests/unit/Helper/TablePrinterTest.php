<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Helper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Helper\TablePrinter;
use DrupalCodeGenerator\InputOutput\IO;
use DrupalCodeGenerator\Tests\Unit\QuestionHelper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A test for output handler.
 */
final class TablePrinterTest extends TestCase {

  /**
   * Console Output.
   */
  private BufferedOutput $output;

  /**
   * Result printer.
   */
  private TablePrinter $printer;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();

    $input = new ArgvInput();
    $this->output = new BufferedOutput();

    $question_helper = new QuestionHelper();
    $io = new IO($input, $this->output, $question_helper);

    $this->printer = new TablePrinter();
    $this->printer->io($io);
  }

  /**
   * Test callback.
   */
  public function testDefaultOutput(): void {
    $this->output->setVerbosity(OutputInterface::VERBOSITY_VERBOSE);

    $assets = new AssetCollection();
    $assets[] = new File('bbb/eee/ggg.php');
    $assets[] = (new File('aaa/ddd.txt'))->content('123');
    $assets[] = (new File('ccc'))->content("123\n456\789");
    $assets[] = (new File('/tmp/aaa'))->content('123');
    $assets[] = new File('bbb/fff.module');
    $assets[] = new Symlink('bbb/fff.module.link', 'bbb/fff.module');
    $assets[] = new Directory('ddd');

    $this->printer->printAssets($assets);

    $expected_output = <<< 'TEXT'

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     ----------- --------------------- ------- ------ 
      Type        Path                  Lines   Size  
     ----------- --------------------- ------- ------ 
      directory   ddd                       -      -  
      file        ccc                       2     10  
      file        /tmp/aaa                  1      3  
      file        aaa/ddd.txt               1      3  
      file        bbb/fff.module            0      0  
      file        bbb/eee/ggg.php           0      0  
      symlink     bbb/fff.module.link       -      -  
     ----------- --------------------- ------- ------ 
                  Total: 7 assets           4   16 B  
     ----------- --------------------- ------- ------ 


    TEXT;
    self::assertSame($expected_output, $this->output->fetch());
  }

  /**
   * Test callback.
   */
  public function testOutputWithBasePath(): void {
    $this->markTestIncomplete();
  }

  /**
   * Test callback.
   */
  public function testEmptyOutput(): void {
    $this->printer->printAssets(new AssetCollection());
    self::assertSame('', $this->output->fetch());
  }

}
