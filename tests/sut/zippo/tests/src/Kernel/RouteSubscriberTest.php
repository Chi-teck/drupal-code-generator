<?php declare(strict_types = 1);

namespace Drupal\Tests\zippo\Kernel;

use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\Core\Routing\RoutingEvents;
use Drupal\KernelTests\KernelTestBase;
use Drupal\zippo\EventSubscriber\ZippoRouterSubscibrer;

/**
 * Route subscriber test.
 *
 * @group DCG
 */
final class RouteSubscriberTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['zippo'];

  /**
   * Test callback.
   */
  public function testSubscriber(): void {
    // The generated subscriber does nothing. So we just check that it exists
    // and has subscribed to the route alter event.
    $subscribers = \array_filter(
      $this->container->get('event_dispatcher')->getListeners(RoutingEvents::ALTER),
      static fn (array $callback): bool => $callback[0] instanceof ZippoRouterSubscibrer,
    );
    self::assertCount(1, $subscribers);
    $subscriber = \array_shift($subscribers)[0];
    self::assertInstanceOf(RouteSubscriberBase::class, $subscriber);
  }

}
