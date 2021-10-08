<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

/**
 * Simple data structure to represent a directory being created.
 */
final class Directory extends Asset {

  /**
   * {@inheritdoc}
   */
  public function __construct(string $path) {
    parent::__construct($path);
    $this->mode(0755);
  }

}
