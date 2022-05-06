<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\RouteSubscriber;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:route-subscriber generator.
 */
final class RouteSubscriberTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_route_subscriber';

  public function testGenerator(): void {

    $input = [
      'foo',
      'BarRouteSubscriber',
      'No',
    ];
    $this->execute(new RouteSubscriber(), $input);

    $expected_display = <<< 'TXT'

     Welcome to route-subscriber generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Class [FooRouteSubscriber]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/EventSubscriber/BarRouteSubscriber.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/EventSubscriber/BarRouteSubscriber.php');
  }

}
