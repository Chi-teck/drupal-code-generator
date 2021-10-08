<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:queue-worker command.
 */
final class QueueWorkerTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\QueueWorker';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin label [Example]:' => 'Test',
    'Plugin ID [example_test]:' => 'example_foo_bar',
    'Plugin class [FooBar]:' => 'FooBar',
  ];

  protected array $fixtures = [
    'src/Plugin/QueueWorker/FooBar.php' => '/_queue_worker.php',
  ];

}
