<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Helper\Printer;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\Printer\ListPrinter;
use DrupalCodeGenerator\InputOutput\IO;
use DrupalCodeGenerator\Tests\Unit\QuestionHelper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * A test for output handler.
 */
final class ListPrinterTest extends TestCase {

  /**
   * Console Output.
   */
  private BufferedOutput $output;

  /**
   * Asset printer.
   */
  private ListPrinter $printer;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $this->output = new BufferedOutput();
    $io = new IO(new ArgvInput(), $this->output, new QuestionHelper());
    $this->printer = new ListPrinter();
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

    $this->printer->printAssets($assets);
    $expected_output = <<< 'TEXT'

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • ccc
     • /tmp/aaa
     • aaa/ddd.txt
     • bbb/fff.module
     • bbb/eee/ggg.php


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

    $this->printer->printAssets($assets, '/project/root/');
    $expected_output = <<< 'TEXT'

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • /project/root/ccc
     • /tmp/aaa
     • /project/root/aaa/ddd.txt
     • /project/root/bbb/fff.module
     • /project/root/bbb/eee/ggg.php


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
