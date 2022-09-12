<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\CKEditor;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:ckeditor generator.
 */
final class CKEditorTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_ckeditor';

  public function testGenerator(): void {
    $input = [
      'foo',
      'Pooh Bear',
      'foo_pooh_bear',
    ];
    $this->execute(CKEditor::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to ckeditor generator!
    ––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [foo_pooh_bear]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • js/build
     • .gitignore
     • foo.ckeditor5.yml
     • foo.libraries.yml
     • package.json
     • webpack.config.js
     • css/pooh-bear.admin.css
     • icons/pooh-bear.svg
     • js/ckeditor5_plugins/poohBear/src/index.js
     • js/ckeditor5_plugins/poohBear/src/PoohBear.js

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedDirectory('js/build');
    $this->assertGeneratedFile('.gitignore');
    $this->assertGeneratedFile('foo.ckeditor5.yml');
    $this->assertGeneratedFile('foo.libraries.yml');
    $this->assertGeneratedFile('package.json');
    $this->assertGeneratedFile('webpack.config.js');
    $this->assertGeneratedFile('css/pooh-bear.admin.css');
    $this->assertGeneratedFile('icons/pooh-bear.svg');
    $this->assertGeneratedFile('js/ckeditor5_plugins/poohBear/src/PoohBear.js');
    $this->assertGeneratedFile('js/ckeditor5_plugins/poohBear/src/index.js');
  }

}
