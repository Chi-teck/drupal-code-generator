<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:ckeditor command.
 */
class CKEditorTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\CKEditor';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Foo',
    'Module machine name [foo]: ' => 'foo',
    'Plugin label [Example]: ' => 'Example',
    'Plugin ID [foo_example]: ' => 'foo_example',
  ];

  protected $fixtures = [
    'js/plugins/example/dialogs/example.js' => __DIR__ . '/_ckeditor/_dialog.js',
    'js/plugins/example/icons/example.png' => __DIR__ . '/_ckeditor/_icon.png',
    'js/plugins/example/plugin.js' => __DIR__ . '/_ckeditor/_plugin.js',
    'src/Plugin/CKEditorPlugin/Example.php' => __DIR__ . '/_ckeditor/_ckeditor.php',
  ];

}
