<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Style\GeneratorStyle;

final class ResolverDefinition {

  public function __construct(
    readonly public string $className,
    readonly public mixed $options = NULL,
  ) {}

  public function createResolver(GeneratorStyle $io): ResolverInterface {
    return new $this->className($io, $this->options);
  }

}
