<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Yaml;

use DrupalCodeGenerator\Command\Yml\Permissions;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests yml:permissions generator.
 */
final class PermissionsTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_permissions';

  public function testGenerator(): void {

    $this->execute(Permissions::class, ['example']);

    $expected_display = <<< 'TXT'

     Welcome to permissions generator!
    –––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.permissions.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.permissions.yml');
  }

}
