<?php

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:route-subscriber command.
 */
class RouteSubscriberGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Service\RouteSubscriber';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_route_subscriber.services.yml',
    'src/EventSubscriber/FooRouteSubscriber.php' => __DIR__ . '/_route_subscriber.php',
  ];

}
