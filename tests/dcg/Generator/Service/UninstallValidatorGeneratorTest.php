<?php

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:uninstall-validator command.
 */
class UninstallValidatorGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Service\UninstallValidator';

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
