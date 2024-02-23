<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\QueueWorker;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:queue-worker generator.
 */
final class QueueWorkerTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_queue_worker';

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {
    $input = [
      'example',
      'Test',
      'example_foo_bar',
      'FooBar',
      'No',
    ];
    $this->execute(QueueWorker::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to queue-worker generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [example_test]:
     ➤ 

     Plugin class [FooBar]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • src/Plugin/QueueWorker/FooBar.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/Plugin/QueueWorker/FooBar.php', '_n_deps/src/Plugin/QueueWorker/FooBar.php');
  }

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {
    $input = [
      'example',
      'Test',
      'example_foo_bar',
      'FooBar',
      'Yes',
      'theme.negotiator',
      '',
    ];
    $this->execute(QueueWorker::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to queue-worker generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [example_test]:
     ➤ 

     Plugin class [FooBar]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • src/Plugin/QueueWorker/FooBar.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/Plugin/QueueWorker/FooBar.php', '_w_deps/src/Plugin/QueueWorker/FooBar.php');
  }

}
