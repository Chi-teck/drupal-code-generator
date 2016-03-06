<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Theme;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:theme:standard command.
 */
class StandardTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Theme\Standard';
    $this->answers = [
      'Foo',
      'foo',
      'classy',
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

    $lines[] = 'The following directories and files have been created:';
    $lines[] = '- foo/foo.info.yml';
    $lines[] = '- foo/foo.libraries.yml';
    $lines[] = '- foo/foo.theme';
    $lines[] = '- foo/js/foo.js';
    $lines[] = '- foo/templates';
    $lines[] = '- foo/images';
    $lines[] = '- foo/css/base/elements.css';
    $lines[] = '- foo/css/components/block.css';
    $lines[] = '- foo/css/components/breadcrumb.css';
    $lines[] = '- foo/css/components/field.css';
    $lines[] = '- foo/css/components/form.css';
    $lines[] = '- foo/css/components/header.css';
    $lines[] = '- foo/css/components/menu.css';
    $lines[] = '- foo/css/components/messages.css';
    $lines[] = '- foo/css/components/node.css';
    $lines[] = '- foo/css/components/sidebar.css';
    $lines[] = '- foo/css/components/table.css';
    $lines[] = '- foo/css/components/tabs.css';
    $lines[] = '- foo/css/components/buttons.css';
    $lines[] = '- foo/css/layouts/layout.css';
    $lines[] = '- foo/css/theme/print.css';
    $lines[] = '';

    $output = implode("\n", $lines);
    $this->assertEquals($output, $this->commandTester->getDisplay());

  }

}
