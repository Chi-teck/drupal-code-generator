<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:block command.
 */
class BlockTest extends BaseGeneratorTest {

  protected $class = 'Plugin\Block';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Block admin label [Example]:' => 'Example',
    'Plugin ID [foo_example]:' => 'foo_example',
    'Plugin class [ExampleBlock]:' => 'ExampleBlock',
    'Block category [Custom]:' => 'Custom',
    'Make the block configurable? [No]:' => 'Yes',
    'Would you like to inject dependencies? [No]:' => 'Yes',
    '<1> Type the service name or use arrows up/down. Press enter to continue:' => 'cron',
    '<2> Type the service name or use arrows up/down. Press enter to continue:' => '',
    'Create access callback? [No]:' => 'Yes',
  ];

  protected $fixtures = [
    'config/schema/foo.schema.yml' => __DIR__ . '/_block_schema.yml',
    'src/Plugin/Block/ExampleBlock.php' => __DIR__ . '/_block.php',
  ];

}
