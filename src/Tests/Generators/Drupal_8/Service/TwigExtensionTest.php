<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Service;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:service:twig-extension command.
 */
class TwigExtensionTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Service\TwigExtension';
    $this->answers = [
      'Example',
      'example',
      'ExampleTwigExtension',
    ];
    $this->target = 'ExampleTwigExtension.php';
    $this->fixture = __DIR__ . '/_twig_extension.php';

    parent::setUp();
  }

}
