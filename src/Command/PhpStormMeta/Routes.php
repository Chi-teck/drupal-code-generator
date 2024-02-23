<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\Drupal\RouteInfo;

/**
 * Generates PhpStorm meta-data for routes.
 */
final class Routes {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly RouteInfo $routeInfo,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    $routes = $this->routeInfo->getRouteNames();
    $route_attributes = $this->getRouteAttributes();
    return File::create('.phpstorm.meta.php/routes.php')
      ->template('routes.php.twig')
      ->vars(['routes' => $routes, 'route_attributes' => $route_attributes]);
  }

  /**
   * Builds attributes suitable for Route autocompletion.
   */
  private function getRouteAttributes(): array {

    /** @psalm-var array{options: array, requirements: array, defaults: array} $route_attributes */
    $route_attributes = [
      'options' => [],
      'requirements' => [],
      'defaults' => [],
    ];

    foreach ($this->routeInfo->getRoutes() as $route) {
      $route_attributes['options'] += $route->getOptions();
      $route_attributes['requirements'] += $route->getRequirements();
      $route_attributes['defaults'] += $route->getDefaults();
    }

    $is_internal = static fn (string $option_name): bool => \str_starts_with($option_name, '_');
    foreach ($route_attributes as $name => $attributes) {
      $route_attributes[$name] = \array_filter(\array_keys($route_attributes[$name]), $is_internal);
      \sort($route_attributes[$name]);
    }

    return $route_attributes;
  }

}
