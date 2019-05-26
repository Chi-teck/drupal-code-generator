<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for plugin:queue-worker command.
 */
class QueueWorkerTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\QueueWorker';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin label [Example]:' => 'Test',
    'Plugin ID [example_test]:' => 'example_foo_bar',
    'Class [Example]:' => 'FooBar',
  ];

  protected $fixtures = [
    'src/Plugin/QueueWorker/FooBar.php' => __DIR__ . '/_queue_worker.php',
  ];

}
