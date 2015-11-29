<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:module:configuration-entity command.
 */
class ConfigurationEntityTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Module\ConfigurationEntity';
    $this->answers = [
      'Foo',
      'foo',
      'Description',
      'Custom',
      '8.x-1.0',
      'Example',
      'example',
    ];
    parent::setUp();
  }

  /**
   * Test callback.
   */
  public function testExecute() {

    $this->execute();

    $lines[] = 'The following files have been created:';
    $lines[] = '- foo/foo.info.yml';
    $lines[] = '- foo/src/Controller/ExampleListBuilder.php';
    $lines[] = '- foo/src/Form/ExampleForm.php';
    $lines[] = '- foo/src/Form/ExampleDeleteForm.php';
    $lines[] = '- foo/src/ExampleInterface.php';
    $lines[] = '- foo/src/Entity/Example.php';
    $lines[] = '- foo/foo.routing.yml';
    $lines[] = '- foo/foo.links.action.yml';
    $lines[] = '- foo/foo.links.menu.yml';
    $lines[] = '- foo/foo.permissions.yml';
    $lines[] = '- foo/config/schema/foo.schema.yml';
    $lines[] = '';

    $output = implode("\n", $lines);
    $this->assertEquals($output, $this->commandTester->getDisplay());

  }

}
