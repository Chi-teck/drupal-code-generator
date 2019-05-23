<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:permissions command.
 */
class PermissionsGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Yml\Permissions';

  protected $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected $fixtures = [
    'example.permissions.yml' => __DIR__ . '/_permissions.yml',
  ];

}
