<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:composer command.
 */
class ComposerTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Composer';

  protected $answers = [
    'example',
    'Example description.',
    'drupal-module',
    TRUE,
  ];

  protected $fixtures = [
    'composer.json' => __DIR__ . '/_composer.json',
  ];

}
