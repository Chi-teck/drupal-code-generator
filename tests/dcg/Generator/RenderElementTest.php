<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for render-element command.
 */
final class RenderElementTest extends BaseGeneratorTest {

  protected $class = 'RenderElement';

  protected $interaction = [
    'Module machine name [%default_machine_name%]:' => 'foo',
  ];

  protected $fixtures = [
    'src/Element/Entity.php' => '/_render_element.php',
  ];

}
