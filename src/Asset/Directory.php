<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

use DrupalCodeGenerator\Asset\Resolver\PreserveResolver;
use DrupalCodeGenerator\Asset\Resolver\ResolverInterface;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;

/**
 * Simple data structure to represent a directory being created.
 */
final class Directory extends Asset {

  public function __construct(string $path) {
    parent::__construct($path);
    $this->mode(0755);
  }

  /**
   * {@inheritDoc}
   */
  public function getResolver(GeneratorStyleInterface $io): ResolverInterface {
    // Recreating existing directories makes no sense.
    return $this->resolver ?? new PreserveResolver();
  }

}
