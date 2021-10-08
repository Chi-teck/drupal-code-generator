<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:route-subscriber command.
 */
final class RouteSubscriberTest extends BaseGeneratorTest {

  protected string $class = 'Service\RouteSubscriber';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [FooRouteSubscriber]:' => 'BarRouteSubscriber',
    'Would you like to inject dependencies? [No]:' => 'No',
  ];

  protected array $fixtures = [
    'foo.services.yml' => '/_route_subscriber.services.yml',
    'src/EventSubscriber/BarRouteSubscriber.php' => '/_route_subscriber.php',
  ];

}
