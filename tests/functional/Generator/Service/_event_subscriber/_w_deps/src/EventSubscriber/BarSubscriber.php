<?php declare(strict_types = 1);

namespace Drupal\foo\EventSubscriber;

use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @todo Add description for this subscriber.
 */
final class BarSubscriber implements EventSubscriberInterface {

  /**
   * Constructs a BarSubscriber object.
   */
  public function __construct(
    private readonly MessengerInterface $messenger,
  ) {}

  /**
   * Kernel request event handler.
   */
  public function onKernelRequest(RequestEvent $event): void {
    // @todo Place your code here.
  }

  /**
   * Kernel response event handler.
   */
  public function onKernelResponse(ResponseEvent $event): void {
    // @todo Place your code here.
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      KernelEvents::REQUEST => ['onKernelRequest'],
      KernelEvents::RESPONSE => ['onKernelResponse'],
    ];
  }

}
