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
    'foo.services.yml' => '/_theme_negotiator.services.yml',
    'src/Theme/FooNegotiator.php' => '/_theme_negotiator.php',
  ];

}
