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

/**
 * A test for output handler.
 */
final class TablePrinterTest extends TestCase {

  /**
   * Console Output.
   */
  private BufferedOutput $output;

  /**
   * Asset printer.
   */
  private TablePrinter $printer;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $this->output = new BufferedOutput();
    $io = new IO(new ArgvInput(), $this->output, new QuestionHelper());
    $this->printer = new TablePrinter();
    $this->printer->io($io);
  }

  /**
   * Test callback.
   */
  public function testDefaultOutput(): void {

    $assets = new AssetCollection();
    $assets[] = File::create('bbb/eee/ggg.php');
    $assets[] = File::create('aaa/ddd.txt')->content('123');
    $assets[] = File::create('ccc')->content("123\n456\789");
    $assets[] = File::create('/tmp/aaa')->content('123');
    $assets[] = File::create('bbb/fff.module');
    $assets[] = Symlink::create('bbb/fff.module.link', 'bbb/fff.module');
    $assets[] = Directory::create('ddd');

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

    $assets = new AssetCollection();
    $assets[] = File::create('bbb/eee/ggg.php');
    $assets[] = File::create('aaa/ddd.txt')->content('123');
    $assets[] = File::create('ccc')->content("123\n456\789");
    $assets[] = File::create('/tmp/aaa')->content('123');
    $assets[] = File::create('bbb/fff.module');
    $assets[] = Symlink::create('bbb/fff.module.link', 'bbb/fff.module');
    $assets[] = Directory::create('ddd');

    $this->printer->printAssets($assets, 'project/root/');

    $expected_output = <<< 'TEXT'

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     ----------- ---------------------------------- ------- ------ 
      Type        Path                               Lines   Size  
     ----------- ---------------------------------- ------- ------ 
      directory   project/root/ddd                       -      -  
      file        project/root/ccc                       2     10  
      file        /tmp/aaa                               1      3  
      file        project/root/aaa/ddd.txt               1      3  
      file        project/root/bbb/fff.module            0      0  
      file        project/root/bbb/eee/ggg.php           0      0  
      symlink     project/root/bbb/fff.module.link       -      -  
     ----------- ---------------------------------- ------- ------ 
                  Total: 7 assets                        4   16 B  
     ----------- ---------------------------------- ------- ------ 


    TEXT;
    self::assertSame($expected_output, $this->output->fetch());
  }

  /**
   * Test callback.
   */
  public function testEmptyOutput(): void {
    $this->printer->printAssets(new AssetCollection());
    self::assertSame('', $this->output->fetch());
  }

}
