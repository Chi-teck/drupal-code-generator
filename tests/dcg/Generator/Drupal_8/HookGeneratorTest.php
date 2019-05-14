<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:hook command.
 */
class HookGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Hook';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Hook name:' => 'theme',
  ];

  protected $fixtures = [
    'example.module' => __DIR__ . '/_hook.module',
  ];

}
