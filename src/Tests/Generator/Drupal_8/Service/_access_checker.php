<?php

namespace Drupal\example\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Symfony\Component\Routing\Route;

/**
 * Checks if passed parameter matches the route configuration.
 *
 * @DCG
 * To make use of this access checker add '_foo: Some value' entry to route
 * definition under requirements section.
 */
class FooAccessChecker implements AccessInterface {

  /**
   * Access callback.
   *
   * @param \Symfony\Component\Routing\Route $route
   *   The route to check against.
   * @param \ExampleInterface $parameter
   *   The parameter to test.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(Route $route, \ExampleInterface $parameter) {
    return AccessResult::allowedIf($parameter->getSomeValue() == $route->getRequirement('_foo'));
  }

}
