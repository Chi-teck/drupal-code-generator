<?php

declare(strict_types=1);

namespace Drupal\Tests\yety\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Tests local tasks.
 *
 * @group DCG
 */
final class LocalTasksTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['yety'];

  /**
   * Test callback.
   *
   * @dataProvider localTasksProvider
   */
  public function testLocalTasks(
    string $id,
    string $title,
    string $route_name,
    string $base_route_name,
    int $weight,
  ): void {
    $plugin = $this->container->get('plugin.manager.menu.local_task')
      ->createInstance($id);
    self::assertSame($title, $plugin->getTitle());
    self::assertSame($route_name, $plugin->getRouteName());
    self::assertSame($base_route_name, $plugin->getPluginDefinition()['base_route']);
    // Return values of some plugin methods do not match types declared in the
    // LocalTaskInterface interface.
    self::assertSame($weight, (int) $plugin->getWeight());
  }

  /**
   * Data provider for testLocalTasks().
   */
  private static function localTasksProvider(): array {
    $definitions[] = [
      'yety.foo',
      'Foo',
      'yety.foo_1',
      'yety.foo_1',
      // Plugin manager sets weight to -10 for root task.
      // @see \Drupal\Core\Menu\LocalTaskDefault::getWeight()
      -10,
    ];
    $definitions[] = [
      'yety.foo_1',
      'Foo 1',
      'yety.foo_1',
      '',
      0,
    ];
    $definitions[] = [
      'yety.foo_2',
      'Foo 2',
      'yety.foo_2',
      '',
      0,
    ];
    $definitions[] = [
      'yety.foo_3',
      'Foo 3',
      'yety.foo_3',
      '',
      0,
    ];
    $definitions[] = [
      'yety.bar',
      'Bar',
      'yety.bar',
      'yety.foo_1',
      0,
    ];
    return $definitions;
  }

}
