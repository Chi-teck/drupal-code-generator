<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:plugin:block command.
 */
class BlockTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\Block';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
    'foo_example',
    'Custom',
  ];

  protected $fixtures = [
    'src/Plugin/Block/ExampleBlock.php' => __DIR__ . '/_block.php',
  ];

}
