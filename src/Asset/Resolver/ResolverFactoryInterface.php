<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Style\GeneratorStyle;

/**
 * Interface for classes capable of creating resolvers.
 */
interface ResolverFactoryInterface {

  /**
   * Creates a resolver.
   */
  public static function createResolver(GeneratorStyle $io, mixed $options): ResolverInterface;

}
