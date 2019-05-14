<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:service:theme-negotiator command.
 */
class ThemeNegotiatorGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Service\ThemeNegotiator';

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
