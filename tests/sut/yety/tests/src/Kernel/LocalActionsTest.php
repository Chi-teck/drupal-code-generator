<?php

declare(strict_types=1);

namespace Drupal\Tests\yety\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Tests local actions.
 *
 * @group DCG
 */
final class LocalActionsTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['yety'];

  /**
   * Test callback.
   */
  public function testLocalActions(): void {
    /** @var \Drupal\Core\Menu\LocalActionDefault $plugin */
    $plugin = $this->container->get('plugin.manager.menu.local_action')
      ->createInstance('yety.add_example');
    $definition = $plugin->getPluginDefinition();
    self::assertSame('yety.add_example', $plugin->getRouteName());
    self::assertSame(['node' => 123], $definition['route_parameters']);
    self::assertSame(['attributes' => ['target' => '_blank']], $definition['options']);
    self::assertSame(10, $plugin->getWeight());
    self::assertSame('Add example', $plugin->getTitle());
  }

}
