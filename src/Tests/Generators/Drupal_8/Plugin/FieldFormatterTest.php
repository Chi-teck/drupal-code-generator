<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:field-formatter command.
 */
class FieldFormatterTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\FieldFormatter';

  protected $answers = [
    'Foo',
    'foo',
    'Zoo',
    'foo_zoo',
  ];

  protected $fixtures = [
    'src/Plugin/Field/FieldFormatter/ZooFormatter.php' => __DIR__ . '/_field_formatter.php',
  ];

}
