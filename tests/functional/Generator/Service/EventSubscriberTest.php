<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\EventSubscriber;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:event-subscriber generator.
 */
final class EventSubscriberTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_event_subscriber';

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {
    $input = [
      'foo',
      'Foo',
      'BarSubscriber',
      'No',
    ];
    $this->execute(EventSubscriber::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to event-subscriber generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Class [FooSubscriber]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/EventSubscriber/BarSubscriber.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml', '_n_deps/foo.services.yml');
    $this->assertGeneratedFile('src/EventSubscriber/BarSubscriber.php', '_n_deps/src/EventSubscriber/BarSubscriber.php');
  }

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {
    $input = [
      'foo',
      'Foo',
      'BarSubscriber',
      'Yes',
      'messenger',
      '',
    ];
    $this->execute(EventSubscriber::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to event-subscriber generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
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

    $this->assertGeneratedFile('foo.services.yml', '_w_deps/foo.services.yml');
    $this->assertGeneratedFile('src/EventSubscriber/BarSubscriber.php', '_w_deps/src/EventSubscriber/BarSubscriber.php');
  }

}
