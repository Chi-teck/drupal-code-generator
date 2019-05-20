<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:plugin:queue-worker command.
 */
class QueueWorkerGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Plugin\QueueWorker';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin label [Example]:' => 'Test',
    'Plugin ID [example_test]:' => 'example_foo_bar',
    'Plugin class [FooBar]:' => 'FooBar',
  ];

  protected $fixtures = [
    'src/Plugin/QueueWorker/FooBar.php' => __DIR__ . '/_queue_worker.php',
  ];

}
