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

    $values = [
      'example',
      'Administer example_id types!',
      'administer example_id types',
      'Optional description.',
      'yes',
    ];
    $this->execute(Permissions::class, $values);

    $expected_display = <<< 'TXT'

     Welcome to permissions generator!
    –––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Permission title [Administer example configuration]:
     ➤ 

     Permission ID [administer example_id types]:
     ➤ 

     Permission description:
     ➤ 

     Display warning about site security on the Permissions page? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • example.permissions.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.permissions.yml');
  }

}
