<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\InputOutput\IO;

/**
 * Interface for classes capable of creating resolvers.
 */
interface ResolverFactoryInterface {

  /**
   * Creates a resolver.
   */
  public static function createResolver(IO $io, mixed $options): ResolverInterface;

}
