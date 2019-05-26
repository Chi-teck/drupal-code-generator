<?php

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service/event-subscriber command.
 */
class EventSubscriberTest extends BaseGeneratorTest {

  protected $class = 'Service\EventSubscriber';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_event_subscriber.services.yml',
    'src/EventSubscriber/FooSubscriber.php' => __DIR__ . '/_event_subscriber.php',
  ];

}
