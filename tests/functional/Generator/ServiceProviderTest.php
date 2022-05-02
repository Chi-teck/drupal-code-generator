<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\ServiceProvider;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service-provider generator.
 */
final class ServiceProviderTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_service_provider';

  public function testGenerator(): void {
    $this->execute(new ServiceProvider(), ['example']);

    $expected_display = <<< 'TXT'

     Welcome to service-provider generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/ExampleServiceProvider.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/ExampleServiceProvider.php');
  }

}
