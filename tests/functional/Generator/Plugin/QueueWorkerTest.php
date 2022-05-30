<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\QueueWorker;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:queue-worker generator.
 */
final class QueueWorkerTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_queue_worker';

  public function testGenerator(): void {
    $input = [
      'example',
      'Test',
      'example_foo_bar',
      'FooBar',
    ];
    $this->execute(QueueWorker::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to queue-worker generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Plugin label [Example]:
     ➤ 

     Plugin ID [example_test]:
     ➤ 

     Plugin class [FooBar]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/QueueWorker/FooBar.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/Plugin/QueueWorker/FooBar.php');
  }

}
