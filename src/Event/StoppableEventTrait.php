<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Event;

/**
 * A trait to implement stoppable events.
 *
 * DCG events are not actually stoppable. This is just a workaround for Drupal
 * core bug.
 *
 * @see https://www.drupal.org/project/drupal/issues/3319791
 */
trait StoppableEventTrait {

  /**
   * Indicates that the event propagation should not be stopped.
   */
  public function isPropagationStopped(): bool {
    return FALSE;
  }

}
