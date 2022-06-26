<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

use DrupalCodeGenerator\Asset\Resolver\ResolverInterface;
use DrupalCodeGenerator\Asset\Resolver\SymlinkResolver;
use DrupalCodeGenerator\Helper\DumperOptions;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;

/**
 * Simple data structure to represent a symlink being generated.
 */
final class Symlink extends Asset {

  /**
   * Symlink target.
   */
  private string $target;

  /**
   * {@inheritdoc}
   */
  public function __construct(string $path, string $target) {
    parent::__construct($path);
    $this->target = $target;
    $this->mode(0644);
  }

  /**
   * Getter for symlink target.
   *
   * @return string
   *   Asset resolverAction.
   */
  public function getTarget(): string {
    return $this->replaceTokens($this->target);
  }

  /**
   * {@inheritDoc}
   */
  public function getResolver(GeneratorStyleInterface $io, DumperOptions $options): ResolverInterface {
    return $this->resolver ?? new SymlinkResolver($options, $io);
  }

}
