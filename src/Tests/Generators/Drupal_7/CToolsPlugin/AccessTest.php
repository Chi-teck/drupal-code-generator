<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\CtoolsPlugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:ctools-plugin:access command.
 */
class AccessTest extends GeneratorTestCase {

  protected $class = 'Drupal_7\CToolsPlugin\Access';
  protected $answers = [
    'Foo',
    'foo',
    'Example',
    'example',
    'Some description',
    'Custom',
    'User',
  ];
  protected $fixtures = [
    'plugins/access/example.inc' => __DIR__ . '/_access.inc',
  ];

}
