<?php

namespace Drupal\Tests\qux\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Tests queue worker plugin.
 *
 * @group DCG
 */
class QueueWorkerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['qux'];

  /**
   * Test callback.
   */
  public function testPlugin() {
    /** @var \Drupal\Core\Queue\QueueWorkerInterface $plugin */
    $plugin = \Drupal::service('plugin.manager.queue_worker')
      ->createInstance('qux_example');

    // Check plugin definition.
    self::assertEquals('qux_example', $plugin->getPluginId());
    self::assertEquals('Example', $plugin->getPluginDefinition()['title']);
    self::assertSame(['time' => 60], $plugin->getPluginDefinition()['cron']);

    // As the plugin does nothing just make sure it can process items without
    // any errors.
    $queue = \Drupal::queue('qux_example');
    $queue->createQueue();

    $queue->createItem(['foo' => 'bar']);
    self::assertSame(1, $queue->numberOfItems());

    \Drupal::service('cron')->run();
    self::assertSame(0, $queue->numberOfItems());
  }

}
