<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:event-subscriber command.
 */
class EventSubscriber extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\EventSubscriber';
    $this->answers = [
      'Foo',
      'foo',
    ];
    $this->target = 'FooSubscriber.php';
    $this->fixture = __DIR__ . '/_event_subscriber.php';
    parent::setUp();
  }

}
