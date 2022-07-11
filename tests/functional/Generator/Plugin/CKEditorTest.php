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
      'Example',
      'foo_example',
      'Example',
    ];
    $this->execute(CKEditor::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to ckeditor generator!
    ––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label [Example]:
     ➤ 

     Plugin ID [foo_example]:
     ➤ 

     Plugin class [Example]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • js/plugins/example/plugin.js
     • js/plugins/example/dialogs/example.js
     • js/plugins/example/icons/example.png
     • src/Plugin/CKEditorPlugin/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('js/plugins/example/plugin.js');
    $this->assertGeneratedFile('js/plugins/example/dialogs/example.js');
    $this->assertGeneratedFile('js/plugins/example/icons/example.png');
    $this->assertGeneratedFile('src/Plugin/CKEditorPlugin/Example.php');
  }

}
