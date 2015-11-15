<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\CtoolsPlugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:ctools-plugin:access command.
 */
class AccessTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_7\CToolsPlugin\Access';
    $this->answers = [
      'Example',
      'example',
      'Some description',
      'custom',
      'User',
    ];
    $this->target = 'example.inc';
    $this->fixture = __DIR__ . '/_access.inc';

    parent::setUp();
  }

}
