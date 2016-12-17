<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Service;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:service/event-subscriber command.
 */
class EventSubscriberTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Service\EventSubscriber';

  protected $answers = [
    'Foo',
    'foo',
  ];

  protected $fixtures = [
    'src/EventSubscriber/FooSubscriber.php' => __DIR__ . '/_event_subscriber.php',
  ];

}
