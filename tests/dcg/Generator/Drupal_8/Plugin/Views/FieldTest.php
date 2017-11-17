<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:views:field command.
 */
class FieldTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\Views\Field';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin label [Example]:' => 'Example',
    'Plugin ID [foo_example]:' => 'foo_example',
  ];

  protected $fixtures = [
    'src/Plugin/views/field/Example.php' => __DIR__ . '/_field.php',
  ];

}
