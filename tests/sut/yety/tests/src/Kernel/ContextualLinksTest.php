<?php declare(strict_types = 1);

namespace Drupal\Tests\yety\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Tests contextual links.
 *
 * @group DCG
 */
final class ContextualLinksTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['yety'];

  /**
   * Test callback.
   */
  public function testContextualLinks(): void {
    /** @var \Drupal\Core\Menu\ContextualLinkInterface $plugin */
    $plugin = $this->container->get('plugin.manager.menu.contextual_link')
      ->createInstance('yety.node_revisions');
    self::assertSame('entity.node.version_history', $plugin->getRouteName());
    self::assertSame('Revisions', $plugin->getTitle());
    self::assertSame([], $plugin->getOptions());
    // A bug in Drupal core. The method is supposed to always return integer.
    // @see \Drupal\Core\Menu\ContextualLinkInterface::getWeight
    self::assertNull($plugin->getWeight());
  }

}
