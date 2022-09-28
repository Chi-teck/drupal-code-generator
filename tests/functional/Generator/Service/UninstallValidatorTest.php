<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\UninstallValidator;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:uninstall-validator generator.
 */
final class UninstallValidatorTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_uninstall_validator';

  public function testGenerator(): void {

    $input = [
      'foo',
      'Foo',
      'ExampleUninstallValidator',
      'Yes',
      'entity_type.manager',
      '',
    ];
    $this->execute(UninstallValidator::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to uninstall-validator generator!
    –––––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Class [FooUninstallValidator]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/ExampleUninstallValidator.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/ExampleUninstallValidator.php');
  }

}
