<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\RouteSubscriber;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:route-subscriber generator.
 */
final class RouteSubscriberTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_route_subscriber';

  public function testWithDependencies(): void {

    $input = [
      'foo',
      '',
      'Yes',
      'entity_type.manager',
      '',
    ];
    $this->execute(RouteSubscriber::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to route-subscriber generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [FooRouteSubscriber]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • foo.services.yml
     • src/EventSubscriber/FooRouteSubscriber.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/EventSubscriber/FooRouteSubscriber.php');
  }

  public function testWithoutDependencies(): void {

    $input = [
      'bar',
      'BarRouteSubscriber',
      'No',
    ];
    $this->execute(RouteSubscriber::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to route-subscriber generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [BarRouteSubscriber]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • bar.info.yml
     • bar.services.yml
     • src/EventSubscriber/BarRouteSubscriber.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('bar.services.yml');
    $this->assertGeneratedFile('src/EventSubscriber/BarRouteSubscriber.php');
  }

}
