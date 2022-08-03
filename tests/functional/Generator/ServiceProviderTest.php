<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\ServiceProvider;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service-provider generator.
 */
final class ServiceProviderTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_service_provider';

  /**
   * Test callback.
   */
  public function testBoth(): void {
    $this->execute(ServiceProvider::class, ['foo', 'Foo', 'Yes', 'Yes']);

    $expected_display = <<< 'TXT'

     Welcome to service-provider generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Would you like to provide new services? [Yes]:
     ➤ 

     Would you like to modify existing services? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/FooServiceProvider.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/FooServiceProvider.php', '_both/src/FooServiceProvider.php');
  }

  /**
   * Test callback.
   */
  public function testProvider(): void {
    $this->execute(ServiceProvider::class, ['foo', 'Foo', 'Yes', 'No']);
    $this->assertGeneratedFile('src/FooServiceProvider.php', '_provider/src/FooServiceProvider.php');
  }

  /**
   * Test callback.
   */
  public function testModifier(): void {
    $this->execute(ServiceProvider::class, ['foo', 'Foo', 'No', 'Yes']);
    $this->assertGeneratedFile('src/FooServiceProvider.php', '_modifier/src/FooServiceProvider.php');
  }

  /**
   * Test callback.
   */
  public function testNone(): void {
    $this->execute(ServiceProvider::class, ['foo', 'Foo', 'No', 'No']);

    $expected_display = <<< 'TXT'

     Welcome to service-provider generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Would you like to provide new services? [Yes]:
     ➤ 

     Would you like to modify existing services? [Yes]:
     ➤ 

    Congratulations! You don't need a service provider.

    TXT;
    $this->assertDisplay($expected_display);
  }

}
