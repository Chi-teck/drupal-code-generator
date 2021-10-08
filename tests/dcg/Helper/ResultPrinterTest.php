<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Helper\ResultPrinter;
use DrupalCodeGenerator\Style\GeneratorStyle;
use DrupalCodeGenerator\Tests\QuestionHelper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A test for output handler.
 */
final class ResultPrinterTest extends TestCase {

  /**
   * Console Output.
   */
  private BufferedOutput $output;

  /**
   * Result printer.
   */
  private ResultPrinter $printer;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();

    $input = new ArgvInput();
    $this->output = new BufferedOutput();

    $question_helper = new QuestionHelper();
    $io = new GeneratorStyle($input, $this->output, $question_helper);

    $this->printer = new ResultPrinter();
    $this->printer->io($io);
  }

  /**
   * Test callback.
   */
  public function testDefaultOutput(): void {

    $assets = new AssetCollection();
    $assets[] = new File('bbb/eee/ggg.php');
    $assets[] = (new File('aaa/ddd.txt'))->content('123');
    $assets[] = (new File('ccc'))->content("123\n456\789");
    $assets[] = (new File('/tmp/aaa'))->content('123');
    $assets[] = new File('bbb/fff.module');

    $this->printer->printResult($assets);
    $expected_output = <<< 'TEXT'

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • ccc
     • aaa/ddd.txt
     • bbb/fff.module
     • /tmp/aaa
     • bbb/eee/ggg.php


    TEXT;
    self::assertSame($expected_output, $this->output->fetch());
  }

  /**
   * Test callback.
   */
  public function testOutputWithBasePath(): void {

    $assets = new AssetCollection();
    $assets[] = new File('bbb/eee/ggg.php');
    $assets[] = (new File('aaa/ddd.txt'))->content('123');
    $assets[] = (new File('ccc'))->content("123\n456\789");
    $assets[] = (new File('/tmp/aaa'))->content('123');
    $assets[] = new File('bbb/fff.module');

    $this->printer->printResult($assets, '/project/root/');
    $expected_output = <<< 'TEXT'

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • /project/root/ccc
     • /project/root/aaa/ddd.txt
     • /project/root/bbb/fff.module
     • /tmp/aaa
     • /project/root/bbb/eee/ggg.php


    TEXT;
    self::assertSame($expected_output, $this->output->fetch());
  }

  /**
   * Test callback.
   */
  public function testEmptyOutput(): void {
    $this->printer->printResult(new AssetCollection());
    self::assertSame('', $this->output->fetch());
  }

  /**
   * Test callback.
   */
  public function testVerboseOutput(): void {
    $this->output->setVerbosity(OutputInterface::VERBOSITY_VERBOSE);

    $assets = new AssetCollection();
    $assets[] = new File('bbb/eee/ggg.php');
    $assets[] = (new File('aaa/ddd.txt'))->content('123');
    $assets[] = (new File('ccc'))->content("123\n456\789");
    $assets[] = (new File('/tmp/aaa'))->content('123');
    $assets[] = new File('bbb/fff.module');
    $assets[] = new Symlink('bbb/fff.module.link', 'bbb/fff.module');
    $assets[] = new Directory('ddd');

    $this->printer->printResult($assets);

    $expected_output = <<< 'TEXT'

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     ----------- --------------------- ------- ------ 
      Type        Path                  Lines   Size  
     ----------- --------------------- ------- ------ 
      directory   ddd                       -      -  
      file        ccc                       2     10  
      file        aaa/ddd.txt               1      3  
      file        bbb/fff.module            0      0  
      file        /tmp/aaa                  1      3  
      file        bbb/eee/ggg.php           0      0  
      symlink     bbb/fff.module.link       -      -  
     ----------- --------------------- ------- ------ 
                  Total: 7 assets           4   16 B  
     ----------- --------------------- ------- ------ 


    TEXT;
    self::assertSame($expected_output, $this->output->fetch());
  }

}
