<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:hook command.
 */
class HookTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Hook';

  protected $answers = [
    'Example',
    'example',
    'theme',
  ];

  protected $fixtures = [
    'example.module' => __DIR__ . '/_hook.module',
  ];

}
