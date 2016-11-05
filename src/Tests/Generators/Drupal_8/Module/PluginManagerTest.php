<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Module;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:module:plugin-manager command.
 */
class PluginManagerTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Module\PluginManager';
    $this->answers = [
      'Foo',
      'foo',
      'Foo description',
      'custom',
      '8.x-1.0',
      'views, fields, node',
    ];
    parent::setUp();
  }

  /**
   * Test callback.
   */
  public function testExecute() {

    $this->execute();

    $lines[] = 'The following directories and files have been created or updated:';
    $lines[] = '- foo/foo.drush.inc';
    $lines[] = '- foo/foo.info.yml';
    $lines[] = '- foo/foo.services.yml';
    $lines[] = '- foo/src/Annotation/Foo.php';
    $lines[] = '- foo/src/FooInterface.php';
    $lines[] = '- foo/src/FooPluginBase.php';
    $lines[] = '- foo/src/FooPluginManager.php';
    $lines[] = '- foo/src/Plugin/Foo/Example.php';
    $lines[] = '';

    $output = implode("\n", $lines);
    $this->assertEquals($output, $this->commandTester->getDisplay());

  }

}
