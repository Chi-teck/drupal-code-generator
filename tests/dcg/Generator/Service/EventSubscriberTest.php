<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service/event-subscriber command.
 */
final class EventSubscriberTest extends BaseGeneratorTest {

  protected string $class = 'Service\EventSubscriber';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [FooSubscriber]:' => 'BarSubscriber',
    'Would you like to inject dependencies? [No]:' => 'Yes',
    '<1> Type the service name or use arrows up/down. Press enter to continue:' => 'messenger',
    '<2> Type the service name or use arrows up/down. Press enter to continue:' => "\n",
  ];

  protected array $fixtures = [
    'foo.services.yml' => '/_event_subscriber.services.yml',
    'src/EventSubscriber/BarSubscriber.php' => '/_event_subscriber.php',
  ];

}
