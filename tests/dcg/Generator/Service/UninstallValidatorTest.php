<?php

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:uninstall-validator command.
 */
final class UninstallValidatorTest extends BaseGeneratorTest {

  protected $class = 'Service\UninstallValidator';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [FooUninstallValidator]:' => 'ExampleUninstallValidator',
  ];

  protected $fixtures = [
    'foo.services.yml' => '/_uninstall_validator.services.yml',
    'src/ExampleUninstallValidator.php' => '/_uninstall_validator.php',
  ];

}
