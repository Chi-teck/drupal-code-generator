<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Event;

/**
 * Fired when altering the registered generators.
 */
final class GeneratorsEvent {

  use StoppableEventTrait;

  /**
   * Constructs the event object.
   */
  public function __construct(public array $generators) {}

}
