<?php declare(strict_types=1);

namespace DrupalCodeGenerator\ClassResolver;

/**
 * Defines a class resolver without dependency injection.
 */
final class SimpleClassResolver implements ClassResolverInterface {

  /**
   * {@inheritdoc}
   */
  public function getInstance(string $class): object {
    if (!\class_exists($class)) {
      throw new \InvalidArgumentException(\sprintf('Class "%s" does not exist.', $class));
    }
    return new $class();
  }

}
