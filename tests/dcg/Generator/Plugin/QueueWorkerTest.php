<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:queue-worker command.
 */
class QueueWorkerTest extends BaseGeneratorTest {

  protected $class = 'Plugin\QueueWorker';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin label [Example]:' => 'Test',
    'Plugin ID [example_test]:' => 'example_foo_bar',
    'Plugin class [FooBar]:' => 'FooBar',
  ];

  protected $fixtures = [
    'src/Plugin/QueueWorker/FooBar.php' => '/_queue_worker.php',
  ];

}
