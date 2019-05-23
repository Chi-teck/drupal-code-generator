<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for render-element command.
 */
class RenderElementGeneratorTest extends BaseGeneratorTest {

  protected $class = 'RenderElement';

  protected $interaction = [
    'Module machine name [%default_machine_name%]:' => 'foo',
  ];

  protected $fixtures = [
    'src/Element/Entity.php' => __DIR__ . '/_render_element.php',
  ];

}
