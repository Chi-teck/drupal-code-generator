<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:yml:permissions command.
 */
class PermissionsTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Yml\Permissions';

  protected $answers = ['example'];

  protected $fixtures = [
    'example.permissions.yml' => __DIR__ . '/_permissions.yml',
  ];

}
