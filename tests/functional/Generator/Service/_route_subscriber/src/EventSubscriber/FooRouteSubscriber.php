<?php declare(strict_types = 1);

namespace Drupal\foo\EventSubscriber;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Route subscriber.
 */
final class FooRouteSubscriber extends RouteSubscriberBase {

  /**
   * Constructs a FooRouteSubscriber object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection): void {
    // @see https://www.drupal.org/node/2187643
  }

}
