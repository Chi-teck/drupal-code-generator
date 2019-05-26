<?php

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:theme-negotiator command.
 */
class ThemeNegotiatorTest extends BaseGeneratorTest {

  protected $class = 'Service\ThemeNegotiator';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [FooNegotiator]:' => 'FooNegotiator',
  ];

  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_theme_negotiator.services.yml',
    'src/Theme/FooNegotiator.php' => __DIR__ . '/_theme_negotiator.php',
  ];

}
