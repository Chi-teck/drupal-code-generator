<?php

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7\CToolsPlugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:ctools-plugin:relationship command.
 */
final class RelationshipTest extends BaseGeneratorTest {

  protected $class = 'Misc\Drupal_7\CToolsPlugin\Relationship';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin name [Example]:' => 'Example',
    'Plugin machine name [example]:' => 'example',
    'Plugin description [Plugin description.]:' => 'Some description.',
    'Category [Custom]:' => 'Custom',
    "Required context:\n  [0] -\n  [1] Node\n  [2] User\n  [3] Term" => 'Term',
  ];

  protected $fixtures = [
    'plugins/relationships/example.inc' => '/_relationship.inc',
  ];

}
