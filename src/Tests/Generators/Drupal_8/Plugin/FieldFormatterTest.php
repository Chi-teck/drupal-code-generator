<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:field-formatter command.
 */
class FieldFormatterTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Plugin\FieldFormatter';
    $this->answers = [
      'Foo',
      'foo',
      'Zoo',
      'foo_zoo',
    ];
    $this->target = 'src/Plugin/Field/FieldFormatter/ZooFormatter.php';
    $this->fixture = __DIR__ . '/_field_formatter.php';

    parent::setUp();
  }

}
