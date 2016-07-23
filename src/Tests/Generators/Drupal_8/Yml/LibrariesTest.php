<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:yml:libraries command.
 *
 * @TODO: Split it into two separate tests for module and theme.
 */
class LibrariesTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Yml\Libraries';
    $this->answers = [
      'Example',
      'example',
      'module',
    ];
    $this->target = 'example.libraries.yml';
    $this->fixture = __DIR__ . '/_libraries.yml';

    parent::setUp();
  }

}
