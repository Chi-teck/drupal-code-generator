<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:route-subscriber command.
 */
class RouteSubscriberTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\RouteSubscriber';
    $this->answers = [
      'Foo',
      'foo',
    ];
    $this->target = 'FooRouteSubscriber.php';
    $this->fixture = __DIR__ . '/_route_subscriber.php';
    parent::setUp();
  }

}
