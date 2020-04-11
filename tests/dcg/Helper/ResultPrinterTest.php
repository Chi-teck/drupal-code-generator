<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\File;
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
   * Test callback.
   */
  public function testResultPrinter() :void {

    $input = new ArgvInput();
    $output = new BufferedOutput();

    $question_helper = new QuestionHelper();
    $io = new GeneratorStyle($input, $output, $question_helper);

    $printer = self::getPrinter($io, TRUE);
    self::assertSame('result_printer', $printer->getName());

    $assets = new AssetCollection();
    $assets[] = (new File('bbb/eee/ggg.php'));
    $assets[] = (new File('aaa/ddd.txt'))->content('123');
    $assets[] = (new File('ccc'))->content("123\n456\789");
    $assets[] = (new File('/tmp/aaa'))->content('123');
    $assets[] = (new File('bbb/fff.module'));

    // -- Default output.
    self::getPrinter($io, FALSE)->printResult($assets);
    $expected_output = <<< 'TEXT'

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • ccc
     • aaa/ddd.txt
     • bbb/fff.module
     • /tmp/aaa
     • bbb/eee/ggg.php


    TEXT;
    self::assertSame($expected_output, $output->fetch());

    // -- Output with base path.
    self::getPrinter($io, TRUE)->printResult($assets, '/project/root/');
    $expected_output = <<< 'TEXT'

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • /project/root/ccc
     • /project/root/aaa/ddd.txt
     • /project/root/bbb/fff.module
     • /tmp/aaa
     • /project/root/bbb/eee/ggg.php


    TEXT;
    self::assertSame($expected_output, $output->fetch());

    // -- Empty output.
    self::getPrinter($io, FALSE)->printResult(new AssetCollection());
    self::assertSame('', $output->fetch());

    // -- Verbose output.
    $output->setVerbosity(OutputInterface::VERBOSITY_VERBOSE);
    self::getPrinter($io, FALSE)->printResult($assets);
    $expected_output = <<< 'TEXT'

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     ------ ----------------- ------- ------ 
      Type   Path              Lines   Size  
     ------ ----------------- ------- ------ 
      file   ccc                   2     10  
      file   aaa/ddd.txt           1      3  
      file   bbb/fff.module        0      0  
      file   /tmp/aaa              1      3  
      file   bbb/eee/ggg.php       0      0  
     ------ ----------------- ------- ------ 
             Total: 5 assets       4   16 B  
     ------ ----------------- ------- ------ 


    TEXT;
    self::assertSame($expected_output, $output->fetch());
  }

  /**
   * Returns result printer.
   */
  private static function getPrinter(GeneratorStyle $io, bool $full_path): ResultPrinter {
    $printer = new ResultPrinter($full_path);
    $printer->io($io);
    return $printer;
  }

}
