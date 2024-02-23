<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\qux\Plugin\Menu\FooExampleLink;

/**
 * Test for menu link plugin.
 *
 * @group DCG
 */
final class MenuLinkTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['qux'];

  /**
   * Test callback.
   */
  public function testMenuLink(): void {

    /** @var \Drupal\Core\Menu\MenuLinkManagerInterface $plugin_manager */
    $plugin_manager = $this->container->get('plugin.manager.menu.link');
    $plugin_manager->rebuild();

    $plugin = $plugin_manager->createInstance('qux.test');

    self::assertInstanceOf(FooExampleLink::class, $plugin);
    self::assertSame('Example', $plugin->getTitle());
    self::assertSame('qux.example', $plugin->getRouteName());
  }

}
