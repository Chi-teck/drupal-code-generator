<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d7:hook command.
 */
class HookTest extends GeneratorTestCase {

  protected $class = 'Drupal_7\Hook';

  protected $answers = [
    'Example',
    'example',
    'init',
  ];

  protected $fixtures = [
    'example.module' => __DIR__ . '/_hook.module',
  ];

}
