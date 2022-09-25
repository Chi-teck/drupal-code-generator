<?php declare(strict_types = 1);

namespace Drupal\Tests\yety\Kernel;

use Drupal\Core\Menu\MenuLinkDefault;
use Drupal\KernelTests\KernelTestBase;
use Drupal\user\Plugin\Menu\LoginLogoutMenuLink;

/**
 * Tests menu links.
 *
 * @group DCG
 */
final class MenuLinksTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['yety'];

  /**
   * Test callback.
   *
   * @dataProvider menuLinksProvider
   */
  public function testMenuLinks(
    string $id,
    string $class,
    string $title,
    string $menu_name,
    string $route_name,
    array $route_parameters,
    array $options,
    int $weight,
  ): void {
    $manager = $this->container->get('plugin.manager.menu.link');
    $manager->rebuild();
    /** @var \Drupal\Core\Menu\MenuLinkInterface $plugin */
    $plugin = $manager->createInstance($id);

    // Return values of some plugin methods do not match types declared in the
    // MenuLinkInterface interface.
    self::assertSame($title, (string) $plugin->getTitle());
    self::assertSame($class, \get_debug_type($plugin));
    self::assertSame($menu_name, $plugin->getMenuName());
    self::assertSame($route_name, $plugin->getRouteName());
    self::assertSame($route_parameters, $plugin->getRouteParameters());
    self::assertSame($options, $plugin->getOptions());
    self::assertSame($weight, (int) $plugin->getWeight());
  }

  /**
   * Data provider for testMenuLinks().
   */
  private static function menuLinksProvider(): array {
    $definitions[] = [
      'yety.node_add',
      MenuLinkDefault::class,
      'Add content',
      'main',
      'node.add_page',
      [],
      [],
      10,
    ];
    $definitions[] = [
      'yety.node_add_article',
      MenuLinkDefault::class,
      'Add article',
      'main',
      'node.add',
      ['node_type' => 'article'],
      [],
      20,
    ];
    $definitions[] = [
      'yety.user',
      LoginLogoutMenuLink::class,
      'Log in',
      'main',
      'user.login',
      [],
      [],
      30,
    ];
    $definitions[] = [
      'yety.drupal.org',
      MenuLinkDefault::class,
      'Drupal.org',
      'main',
      '',
      [],
      ['attributes' => ['target' => '_blank']],
      40,
    ];
    return $definitions;
  }

}
