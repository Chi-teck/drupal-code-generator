<?php

namespace Drupal\yety\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Event subscriber.
 */
final class YetySubscriber implements EventSubscriberInterface {

  /**
   * Kernel request event handler.
   */
  public function onKernelRequest(GetResponseEvent $event): void {
    // Intentionally empty.
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [KernelEvents::REQUEST => ['onKernelRequest']];
  }

}
