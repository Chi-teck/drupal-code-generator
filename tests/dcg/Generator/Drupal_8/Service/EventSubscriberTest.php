<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:service/event-subscriber command.
 */
class EventSubscriberTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Service\EventSubscriber';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [FooSubscriber]:' => 'FooSubscriber',
  ];

  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_event_subscriber.services.yml',
    'src/EventSubscriber/FooSubscriber.php' => __DIR__ . '/_event_subscriber.php',
  ];

}
