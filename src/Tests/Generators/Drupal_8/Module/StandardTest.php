<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:module:standard command.
 */
class StandardTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Module\Standard';
    $this->answers = [
      'Foo',
      'foo',
      'Description',
      'Custom',
      '8.x-1.0',
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
    $lines[] = '- foo/foo.module';
    $lines[] = '- foo/foo.install';
    $lines[] = '- foo/foo.libraries.yml';
    $lines[] = '- foo/foo.permissions.yml';
    $lines[] = '- foo/js/foo.js';
    $lines[] = '- foo/foo.routing.yml';
    $lines[] = '- foo/src/Controller/FooController.php';
    $lines[] = '- foo/src/Form/SettingsForm.php';
    $lines[] = '';

    $output = implode("\n", $lines);
    $this->assertEquals($output, $this->commandTester->getDisplay());

  }

}
