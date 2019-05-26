<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for hook command.
 */
class HookTest extends BaseGeneratorTest {

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
