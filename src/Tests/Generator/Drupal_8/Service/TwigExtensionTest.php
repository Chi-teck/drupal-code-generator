<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:service:twig-extension command.
 */
class TwigExtensionTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Service\TwigExtension';

  protected $answers = [
    'Example',
    'example',
    'ExampleTwigExtension',
  ];

  protected $fixtures = [
    'src/ExampleTwigExtension.php' => __DIR__ . '/_twig_extension.php',
    'example.services.yml' => __DIR__ . '/_twig_extension.services.yml',
  ];

}
