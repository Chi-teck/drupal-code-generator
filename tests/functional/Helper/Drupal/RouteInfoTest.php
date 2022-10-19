<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional;

use DrupalCodeGenerator\Helper\Drupal\RouteInfo;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;

/**
 * Tests 'route info' helper.
 */
final class RouteInfoTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function testGetName(): void {
    $container = $this->application->getContainer();
    $route_info = new RouteInfo($container->get('router.route_provider'));
    self::assertSame('route_info', $route_info->getName());
  }

  /**
   * Test callback.
   */
  public function testGetRouteNames(): void {
    $container = $this->application->getContainer();
    $route_info = new RouteInfo($container->get('router.route_provider'));
    $route_names = $route_info->getRouteNames();
    self::assertGreaterThan(300, \count($route_names));
    self::assertContains('<front>', $route_names);
    self::assertContains('filter.tips', $route_names);
    self::assertContains('image.style_add', $route_names);
    self::assertContains('search.add_type', $route_names);
    self::assertContains('system.modules_list', $route_names);
  }

}
