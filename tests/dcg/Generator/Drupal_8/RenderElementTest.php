<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:render-element command.
 */
class RenderElementTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\RenderElement';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'src/Element/Entity.php' => __DIR__ . '/_render_element.php',
  ];

}
