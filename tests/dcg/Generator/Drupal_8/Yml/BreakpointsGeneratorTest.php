<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:yml:breakpoints command.
 */
class BreakpointsGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Yml\Breakpoints';

  protected $interaction = [
    'Theme machine name [%default_machine_name%]:' => 'example',
  ];

  protected $fixtures = [
    'example.breakpoints.yml' => __DIR__ . '/_breakpoints.yml',
  ];

}
