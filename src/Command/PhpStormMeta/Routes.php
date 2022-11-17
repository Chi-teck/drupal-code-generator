<?php declare(strict_types = 1);

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
    return File::create('.phpstorm.meta.php/routes.php')
      ->template('routes.php.twig')
      ->vars(['routes' => $routes]);
  }

}
