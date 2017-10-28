<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:condition command.
 */
class ConditionTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\Condition';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Foo',
    'Module machine name [foo]: ' => 'foo',
    'Plugin label [Example]: ' => 'Example',
    'Plugin ID [foo_example]: ' => 'foo_example',
  ];

  protected $fixtures = [
    'config/schema/foo.schema.yml' => __DIR__ . '/_condition_schema.yml',
    'src/Plugin/Condition/Example.php' => __DIR__ . '/_condition.php',
  ];

}
