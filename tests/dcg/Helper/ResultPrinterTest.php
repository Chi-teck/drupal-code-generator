<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Asset;
use DrupalCodeGenerator\Helper\ResultPrinter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * A test for output handler.
 */
class ResultPrinterTest extends TestCase {

  /**
   * Test callback.
   */
  public function testOutputHandler() {
    $printer = new ResultPrinter();
    $input = new ArgvInput();
    $output = new BufferedOutput();

    $assets[] = (new Asset())->path('bbb/eee/ggg');
    $assets[] = (new Asset())->path('aaa/ddd');
    $assets[] = (new Asset())->path('ccc');
    $assets[] = (new Asset())->path('aaa');
    $assets[] = (new Asset())->path('bbb/fff');

    $printer->printResult($input, $output, $assets, '');
    $expected_output = "\n";
    $expected_output .= " The following directories and files have been created or updated:\n";
    $expected_output .= "–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––\n";
    $expected_output .= implode([
      " • aaa\n",
      " • ccc\n",
      " • aaa/ddd\n",
      " • bbb/fff\n",
      " • bbb/eee/ggg\n",
      "\n",
    ]);
    self::assertEquals($expected_output, $output->fetch());

    $printer->printResult($input, $output, [], '');
    self::assertEquals('', $output->fetch());

    self::assertEquals('result_printer', $printer->getName());
  }

}
