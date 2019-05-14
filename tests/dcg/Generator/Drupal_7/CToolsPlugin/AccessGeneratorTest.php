<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7\CtoolsPlugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d7:ctools-plugin:access command.
 */
class AccessGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_7\CToolsPlugin\Access';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin name [Example]:' => 'Example',
    'Plugin machine name [example]:' => 'example',
    'Plugin description [Plugin description.]:' => 'Some description.',
    'Category [Custom]:' => 'Custom',
    "Required context:\n  [0] -\n  [1] Node\n  [2] User\n  [3] Term" => 'User',
  ];

  protected $fixtures = [
    'plugins/access/example.inc' => __DIR__ . '/_access.inc',
  ];

}
