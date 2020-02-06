<?php

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:hook command.
 */
final class HookTest extends BaseGeneratorTest {

  protected $class = 'Misc\Drupal_7\Hook';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Hook name:' => 'init',
  ];

  protected $fixtures = [
    'example.module' => '/_hook.module',
  ];

}
