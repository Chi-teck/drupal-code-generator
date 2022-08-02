<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Views;

use DrupalCodeGenerator\Command\Plugin\Views\Style;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:views:style generator.
 */
final class StyleTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_style';

  public function testGenerator(): void {
    $input = [
      'example',
      'Example',
      'Foo',
      'example_foo',
      'Foo',
      'Yes',
    ];
    $this->execute(Style::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to views-style generator!
    –––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Example]:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [example_foo]:
     ➤ 

     Plugin class [Foo]:
     ➤ 

     Make the plugin configurable? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.module
     • config/schema/example.schema.yml
     • src/Plugin/views/style/Foo.php
     • templates/views-style-example-foo.html.twig

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.module');
    $this->assertGeneratedFile('config/schema/example.schema.yml');
    $this->assertGeneratedFile('src/Plugin/views/style/Foo.php');
    $this->assertGeneratedFile('templates/views-style-example-foo.html.twig');
  }

}
