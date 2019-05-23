<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for hook command.
 */
class HookGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Hook';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Hook name:' => 'theme',
  ];

  protected $fixtures = [
    'example.module' => __DIR__ . '/_hook.module',
  ];

}
