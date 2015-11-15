<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:theme-file command.
 */
class ThemeFileTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\ThemeFile';
    $this->answers = [
      'Foo',
      'foo',
    ];
    $this->target = 'foo.theme';
    $this->fixture = __DIR__ . '/_theme_file.theme';
    parent::setUp();
  }

}
