<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\InputOutput\IO;

final class ResolverDefinition {

  /**
   * Constructs the object.
   *
   * @psalm-param class-string<\DrupalCodeGenerator\Asset\Resolver\ResolverInterface> $className
   */
  public function __construct(
    public readonly string $className,
    public readonly mixed $options = NULL,
  ) {}

  /**
   * Creates asset resolver.
   */
  public function createResolver(IO $io): ResolverInterface {
    if (\is_subclass_of($this->className, ResolverFactoryInterface::class)) {
      $resolver = $this->className::createResolver($io, $this->options);
    }
    else {
      $resolver = new $this->className();
    }
    return $resolver;
  }

}
