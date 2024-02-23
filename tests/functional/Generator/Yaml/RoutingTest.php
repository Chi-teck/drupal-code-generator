<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Yaml;

use DrupalCodeGenerator\Command\Yml\Routing;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests yml:routing generator.
 */
final class RoutingTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_routing';

  public function testGenerator(): void {

    $this->execute(Routing::class, ['foo', 'Foo']);

    $expected_display = <<< 'TXT'

     Welcome to routing generator!
    –––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • foo.routing.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.routing.yml');
  }

}
