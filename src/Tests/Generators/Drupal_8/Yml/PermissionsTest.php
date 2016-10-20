<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:yml:permissions command.
 */
class PermissionsTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Yml\Permissions';
    $this->answers = ['example'];
    $this->target = 'example.permissions.yml';
    $this->fixture = __DIR__ . '/_permissions.yml';
    parent::setUp();
  }

}
