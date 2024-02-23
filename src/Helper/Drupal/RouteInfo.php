<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Drupal;

use Drupal\Core\Routing\RouteProviderInterface;
use Symfony\Component\Console\Helper\Helper;

/**
 * A helper that provides information about routes.
 */
final class RouteInfo extends Helper {

  /**
   * Constructs helper.
   */
  public function __construct(
    private readonly RouteProviderInterface $routeProvider,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'route_info';
  }

  /**
   * Returns names of all routes on the system.
   *
   * @psalm-return list<string>
   */
  public function getRouteNames(): array {
    /** @var \Traversable<string,\Symfony\Component\Routing\Route> $routes */
    $routes = $this->routeProvider->getAllRoutes();
    $route_names = \array_keys(\iterator_to_array($routes));
    // Sort names to ease testing.
    \sort($route_names);
    return $route_names;
  }

  /**
   * Returns all routes on the system.
   *
   * @psalm-suppress InvalidReturnType
   * @psalm-suppress InvalidReturnStatement
   */
  public function getRoutes(): \ArrayIterator {
    return $this->routeProvider->getAllRoutes();
  }

}
