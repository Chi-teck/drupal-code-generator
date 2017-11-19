<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:hook command.
 */
class HookTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\Hook';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Hook name:' => 'init',
  ];

  protected $fixtures = [
    'example.module' => __DIR__ . '/_hook.module',
  ];

}
