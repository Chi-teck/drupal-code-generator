<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

use DrupalCodeGenerator\Asset\Resolver\PreserveResolver;
use DrupalCodeGenerator\Asset\Resolver\ReplaceResolver;
use DrupalCodeGenerator\Asset\Resolver\ResolverInterface;
use DrupalCodeGenerator\Style\GeneratorStyleInterface;

/**
 * Simple data structure to represent a symlink being generated.
 */
final class Symlink extends Asset {

  /**
   * Symlink target.
   */
  readonly private string $target;

  /**
   * {@inheritdoc}
   */
  public function __construct(string $path, string $target) {
    parent::__construct($path);
    $this->target = $target;
    $this->mode(0644);
  }

  /**
   * Named constructor.
   */
  final public static function create(string $path, string $target): self {
    return new self($path, $target);
  }

  /**
   * Getter for symlink target.
   */
  public function getTarget(): string {
    return $this->replaceTokens($this->target);
  }

  /**
   * {@inheritDoc}
   */
  public function getResolver(GeneratorStyleInterface $io): ResolverInterface {
    return $this->resolver ?? match ($this->resolverAction) {
      self::RESOLVER_ACTION_PRESERVE => new PreserveResolver(),
      self::RESOLVER_ACTION_REPLACE => new ReplaceResolver($io),
    };
  }

}
