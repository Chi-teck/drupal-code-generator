<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Yaml;

use DrupalCodeGenerator\Command\Yml\Services;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests yml:services generator.
 */
final class ServicesTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_services';

  public function testGenerator(): void {

    $this->execute(Services::class, ['foo', 'Foo']);

    $expected_display = <<< 'TXT'

     Welcome to services generator!
    ––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • foo.services.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml');
  }

}
