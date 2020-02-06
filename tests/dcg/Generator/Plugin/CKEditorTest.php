<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:ckeditor command.
 */
final class CKEditorTest extends BaseGeneratorTest {

  protected $class = 'Plugin\CKEditor';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin label [Example]:' => 'Example',
    'Plugin ID [foo_example]:' => 'foo_example',
    'Plugin class [Example]:' => 'Example',
  ];

  protected $fixtures = [
    'js/plugins/example/dialogs/example.js' => '/_ckeditor/_dialog.js',
    'js/plugins/example/icons/example.png' => '/_ckeditor/_icon.png',
    'js/plugins/example/plugin.js' => '/_ckeditor/_plugin.js',
    'src/Plugin/CKEditorPlugin/Example.php' => '/_ckeditor/_ckeditor.php',
  ];

}
