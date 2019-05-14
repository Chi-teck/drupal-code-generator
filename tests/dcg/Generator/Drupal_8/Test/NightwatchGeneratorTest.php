<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Test;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:test:nightwatch command.
 */
class NightwatchGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Test\Nightwatch';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Test name [example]:' => 'example',
  ];

  protected $fixtures = [
    'tests/src/Nightwatch/exampleTest.js' => __DIR__ . '/_nightwatch.js',
  ];

}
