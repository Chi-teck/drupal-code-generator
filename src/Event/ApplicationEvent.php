<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Event;

use DrupalCodeGenerator\Application;

/**
 * Fired when altering the DCG application.
 */
final class ApplicationEvent {

  use StoppableEventTrait;

  /**
   * Constructs the event object.
   */
  public function __construct(
    public readonly Application $application,
  ) {}

}
