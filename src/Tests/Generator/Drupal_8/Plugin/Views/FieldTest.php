<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:plugin:views:field command.
 */
class FieldTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\Views\Field';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
    'foo_example',
  ];

  protected $fixtures = [
    'src/Plugin/views/field/Example.php' => __DIR__ . '/_field.php',
  ];

}
