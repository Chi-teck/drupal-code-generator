<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:theme-negotiator command.
 */
final class ThemeNegotiatorTest extends BaseGeneratorTest {

  protected string $class = 'Service\ThemeNegotiator';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [FooNegotiator]:' => 'FooNegotiator',
  ];

  protected array $fixtures = [
    'foo.services.yml' => '/_theme_negotiator.services.yml',
    'src/Theme/FooNegotiator.php' => '/_theme_negotiator.php',
  ];

}
