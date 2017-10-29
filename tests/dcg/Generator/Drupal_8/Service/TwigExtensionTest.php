<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:service:twig-extension command.
 */
class TwigExtensionTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Service\TwigExtension';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Example',
    'Module machine name [example]: ' => 'example',
    'Class [ExampleTwigExtension]: ' => 'ExampleTwigExtension',
  ];

  protected $fixtures = [
    'example.services.yml' => __DIR__ . '/_twig_extension.services.yml',
    'src/ExampleTwigExtension.php' => __DIR__ . '/_twig_extension.php',
  ];

}
