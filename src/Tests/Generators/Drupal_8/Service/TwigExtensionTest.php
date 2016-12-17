<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Service;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

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
  ];

}
