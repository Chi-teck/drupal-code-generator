<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:service:route-subscriber command.
 */
class RouteSubscriberTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Service\RouteSubscriber';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_route_subscriber.services.yml',
    'src/EventSubscriber/FooRouteSubscriber.php' => __DIR__ . '/_route_subscriber.php',
  ];

}
