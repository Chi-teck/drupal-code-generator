<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7\CtoolsPlugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:ctools-plugin:content-type command.
 */
class ContentTypeTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\CToolsPlugin\ContentType';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin name [Example]:' => 'Example',
    'Plugin machine name [example]:' => 'example',
    'Plugin description [Plugin description.]:' => 'Some description.',
    'Category [Custom]:' => 'Custom',
    "Required context:\n  [0] -\n  [1] Node\n  [2] User\n  [3] Term\n > " => 'Node',
  ];

  protected $fixtures = [
    'plugins/content_types/example.inc' => __DIR__ . '/_content_type.inc',
  ];

}
