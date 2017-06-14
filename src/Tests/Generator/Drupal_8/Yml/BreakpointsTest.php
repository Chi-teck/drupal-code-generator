<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:yml:breakpoints command.
 */
class BreakpointsTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Yml\Breakpoints';

  protected $answers = [
    'Theme machine name' => 'example',
  ];

  protected $fixtures = [
    'example.breakpoints.yml' => __DIR__ . '/_breakpoints.yml',
  ];

}
