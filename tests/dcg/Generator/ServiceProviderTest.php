<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\Command\ServiceProvider;
use DrupalCodeGenerator\Test\GeneratorTest;

/**
 * Test for service-provider command.
 */
final class ServiceProviderTest extends GeneratorTest {

  protected string $fixtureDir = __DIR__;

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $user_input = ['Example', 'example', 'foo', 'Yes', 'Yes'];
    $this->execute(new ServiceProvider(), $user_input);

    $expected_display = <<< 'TXT'

     Welcome to service-provider generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module name [%default_name%]:
     ➤ 

     Module machine name [example]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/ExampleServiceProvider.php


    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/ExampleServiceProvider.php', '_service_provider.php');
  }

}
