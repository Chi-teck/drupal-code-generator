<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:breakpoints command.
 */
final class BreakpointsTest extends BaseGeneratorTest {

  protected string $class = 'Yml\Breakpoints';

  protected array $interaction = [
    'Theme machine name [%default_machine_name%]:' => 'example',
  ];

  protected array $fixtures = [
    'example.breakpoints.yml' => '/_breakpoints.yml',
  ];

}
