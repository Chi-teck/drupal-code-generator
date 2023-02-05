<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\RenderElement;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests render-element generator.
 */
final class RenderElementTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_render_element';

  public function testGenerator(): void {

    $input = [
      'foo',
      'Wrong ID',
      'example',
      'Example',
    ];
    $this->execute(RenderElement::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to render-element generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Element ID (#type):
     ➤  The value is not correct machine name.

     Element ID (#type):
     ➤ 

     Class [Example]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • src/Element/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/Element/Example.php');
  }

}
