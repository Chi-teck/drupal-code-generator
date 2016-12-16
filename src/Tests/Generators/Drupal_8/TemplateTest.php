<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:template command.
 */
class TemplateTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Template';
    $this->answers = [
      'Example',
      'example',
      'example-foo',
      TRUE,
      TRUE,
    ];
    $this->fixtures['templates/example-foo.html.twig'] = __DIR__ . '/_template.twig';
    $this->fixtures['example.module'] = __DIR__ . '/_template.module';

    parent::setUp();
  }

}
