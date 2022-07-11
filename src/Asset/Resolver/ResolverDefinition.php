<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\InputOutput\IO;

final class ResolverDefinition {

  public function __construct(
    public readonly string $className,
    public readonly mixed $options = NULL,
  ) {}

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
