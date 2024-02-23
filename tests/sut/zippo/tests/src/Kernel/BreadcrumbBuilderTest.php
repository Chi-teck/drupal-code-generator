<?php

declare(strict_types=1);

namespace Drupal\Tests\zippo\Kernel;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteMatch;
use Drupal\KernelTests\KernelTestBase;
use Symfony\Component\Routing\Route;

/**
 * A test for breadcrumb builder.
 *
 * @group DCG
 */
final class BreadcrumbBuilderTest extends KernelTestBase {

  private const EMPTY_CACHE = [
    'contexts' => [],
    'tags' => [],
    'max-age' => Cache::PERMANENT,
  ];

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['zippo'];

  /**
   * Test callback.
   */
  public function testBreadcrumbBuilder(): void {
    $breadcrumb_manager = $this->container->get('breadcrumb');

    $route_match = new RouteMatch('example', new Route('/abc'));
    $actual_build = $breadcrumb_manager->build($route_match)->toRenderable();
    $expected_build = [
      '#cache' => self::EMPTY_CACHE,
      '#theme' => 'breadcrumb',
      '#links' => [
        Link::createFromRoute('Home', '<front>'),
        Link::createFromRoute('Example', '<none>'),
      ],
    ];
    self::assertEquals($expected_build, $actual_build);

    $route_match = new RouteMatch('not_applicable_route', new Route('/abc'));
    $actual_build = $breadcrumb_manager->build($route_match)->toRenderable();
    $expected_build = [
      '#cache' => self::EMPTY_CACHE,
    ];
    self::assertEquals($expected_build, $actual_build);
  }

}
