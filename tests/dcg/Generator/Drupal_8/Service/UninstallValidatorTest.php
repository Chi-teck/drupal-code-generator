<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:service:uninstall-validator command.
 */
class UninstallValidatorTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Service\UninstallValidator';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [FooUninstallValidator]:' => 'ExampleUninstallValidator',
  ];

  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_uninstall_validator.services.yml',
    'src/ExampleUninstallValidator.php' => __DIR__ . '/_uninstall_validator.php',
  ];

}
