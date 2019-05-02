<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Asset;
use DrupalCodeGenerator\Helper\OutputHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * A test for output handler.
 */
class OutputHandlerTest extends TestCase {

  /**
   * Test callback.
   */
  public function testOutputHandler() {
    $handler = new OutputHandler();
    $input = new ArgvInput();
    $output = new BufferedOutput();

    $assets[] = (new Asset())->path('bbb/eee/ggg');
    $assets[] = (new Asset())->path('aaa/ddd');
    $assets[] = (new Asset())->path('ccc');
    $assets[] = (new Asset())->path('aaa');
    $assets[] = (new Asset())->path('bbb/fff');

    $handler->printSummary($input, $output, $assets, '');
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

    $handler->printSummary($input, $output, [], '');
    self::assertEquals('', $output->fetch());

    self::assertEquals('output_handler', $handler->getName());
  }

}
