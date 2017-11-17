<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Helper\OutputHandler;
use PHPUnit\Framework\TestCase;
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
    $output = new BufferedOutput();

    $handler->printSummary(
      $output,
      ['bbb/eee/ggg', 'aaa/ddd', 'ccc', 'aaa', 'bbb/fff']
    );
    $expected_output = "\n";
    $expected_output .= "The following directories and files have been created or updated:\n";
    $expected_output .= "–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––\n";
    $expected_output .= implode([
      "• aaa\n",
      "• ccc\n",
      "• aaa/ddd\n",
      "• bbb/fff\n",
      "• bbb/eee/ggg\n",
    ]);
    self::assertEquals($expected_output, $output->fetch());

    $handler->printSummary($output, []);
    self::assertEquals('', $output->fetch());

    self::assertEquals('dcg_output_handler', $handler->getName());
  }

}
