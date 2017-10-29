<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:block command.
 */
class BlockTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\Block';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Foo',
    'Module machine name [foo]: ' => 'foo',
    'Block admin label [Example]: ' => 'Example',
    'Plugin ID [foo_example]: ' => 'foo_example',
    'Block category [Custom]: ' => 'Custom',
  ];

  protected $fixtures = [
    'config/schema/foo.schema.yml' => __DIR__ . '/_block_schema.yml',
    'src/Plugin/Block/ExampleBlock.php' => __DIR__ . '/_block.php',
  ];

}
