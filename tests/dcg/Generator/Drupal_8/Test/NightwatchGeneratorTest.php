<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Test;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for test:nightwatch command.
 */
class NightwatchGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Test\Nightwatch';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Test name [example]:' => 'example',
  ];

  protected $fixtures = [
    'tests/src/Nightwatch/exampleTest.js' => __DIR__ . '/_nightwatch.js',
  ];

}
