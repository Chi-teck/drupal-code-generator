<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\EventSubscriber;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:event-subscriber generator.
 */
final class EventSubscriberTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_event_subscriber';

  public function testGenerator(): void {
    $input = [
      'foo',
      'BarSubscriber',
      'Yes',
      'messenger',
      '',
    ];
    $this->execute(new EventSubscriber(), $input);

    $expected_display = <<< 'TXT'

     Welcome to event-subscriber generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Class [FooSubscriber]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/EventSubscriber/BarSubscriber.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/EventSubscriber/BarSubscriber.php');
  }

}
