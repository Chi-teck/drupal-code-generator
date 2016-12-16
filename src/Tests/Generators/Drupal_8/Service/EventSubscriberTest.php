<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Service;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:service/event-subscriber command.
 */
class EventSubscriberTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Service\EventSubscriber';
    $this->answers = [
      'Foo',
      'foo',
    ];
    $this->target = 'src/EventSubscriber/FooSubscriber.php';
    $this->fixture = __DIR__ . '/_event_subscriber.php';
    parent::setUp();
  }

}
