<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:plugin:field:formatter command.
 */
class FormatterTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\Field\Formatter';

  protected $answers = [
    'Foo',
    'foo',
    'Zoo',
    'foo_zoo',
  ];

  protected $fixtures = [
    'src/Plugin/Field/FieldFormatter/ZooFormatter.php' => __DIR__ . '/_formatter.php',
  ];

}
