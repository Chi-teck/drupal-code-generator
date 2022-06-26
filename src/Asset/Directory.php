<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

/**
 * Simple data structure to represent a directory being created.
 */
final class Directory extends Asset {

  public function __construct(string $path) {
    parent::__construct($path);
    $this->mode(0755);
  }

  /**
   * {@inheritdoc}
   */
  public function prependIfExists(): self {
    throw new \LogicException('"prepend" action is not supported for directories.');
  }

  /**
   * {@inheritdoc}
   */
  public function appendIfExists(): self {
    throw new \LogicException('"append" action is not supported for directories.');
  }

}
