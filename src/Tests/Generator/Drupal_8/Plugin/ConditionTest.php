<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:plugin:condition command.
 */
class ConditionTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\Condition';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
    'foo_example',
  ];

  protected $fixtures = [
    'src/Plugin/Condition/Example.php' => __DIR__ . '/_condition.php',
  ];

}
