<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\RenderElement;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests render-element generator.
 */
final class RenderElementTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_render_element';

  public function testGenerator(): void {

    $this->execute(RenderElement::class, ['foo']);

    $expected_display = <<< 'TXT'

     Welcome to render-element generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Element/Entity.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/Element/Entity.php');
  }

}
