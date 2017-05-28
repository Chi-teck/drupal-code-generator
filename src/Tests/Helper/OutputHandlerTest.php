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

    $handler->printSummary($output, ['aaa', 'bbb', 'ccc']);
    $expected_output = "<title>The following directories and files have been created or updated:</title>\n- aaa\n- bbb\n- ccc\n";
    $this->assertEquals($output->fetch(), $expected_output);

    $handler->printSummary($output, []);
    $this->assertEquals($output->fetch(), '');

    $this->assertEquals($handler->getName(), 'dcg_output_handler');
  }

}
