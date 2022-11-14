<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Event;

/**
 * Fired when altering registered generators.
 */
final class GeneratorInfoAlter {

  use StoppableEventTrait;

  public array $generators = [];

  /**
   * Constructs the event object.
   */
  public function __construct(array $generators) {
    // Index generators by name to ease access.
    foreach ($generators as $generator) {
      $this->generators[$generator->getName()] = $generator;
    }
  }

}
