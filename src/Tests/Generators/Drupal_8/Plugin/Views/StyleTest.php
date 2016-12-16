<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin\Style;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:views:style command.
 */
class StyleTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Plugin\Views\Style';
    $this->answers = [
      'Example',
      'example',
      'Foo',
      'example_foo',
    ];

    $this->fixtures['src/Plugin/views/style/Foo.php'] = __DIR__ . '/_style.php';
    $this->fixtures['templates/views-style-example-foo.html.twig'] = __DIR__ . '/_style.twig';
    $this->fixtures['example.module'] = __DIR__ . '/_style.module';

    parent::setUp();
  }

}
