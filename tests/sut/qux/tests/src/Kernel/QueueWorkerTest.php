<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Tests queue worker plugin.
 *
 * @group DCG
 */
final class QueueWorkerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux'];

  /**
   * Test callback.
   */
  public function testPlugin(): void {
    /** @var \Drupal\Core\Queue\QueueWorkerInterface $plugin */
    $plugin = $this->container->get('plugin.manager.queue_worker')
      ->createInstance('qux_example');

    // Check plugin definition.
    self::assertEquals('qux_example', $plugin->getPluginId());
    self::assertEquals('Example', $plugin->getPluginDefinition()['title']);
    self::assertSame(['time' => 60], $plugin->getPluginDefinition()['cron']);

    // As the plugin does nothing just make sure it can process items without
    // any errors.
    $queue = $this->container->get('queue')->get('qux_example');
    $queue->createQueue();

    $queue->createItem(['foo' => 'bar']);
    self::assertSame(1, $queue->numberOfItems());

    $this->container->get('cron')->run();
    self::assertSame(0, $queue->numberOfItems());
  }

}
