<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for render-element command.
 */
final class RenderElementTest extends BaseGeneratorTest {

  protected string $class = 'RenderElement';

  protected array $interaction = [
    'Module machine name [%default_machine_name%]:' => 'foo',
  ];

  protected array $fixtures = [
    'src/Element/Entity.php' => '/_render_element.php',
  ];

}
