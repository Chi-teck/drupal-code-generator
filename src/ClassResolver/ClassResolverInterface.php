<?php declare(strict_types=1);

namespace DrupalCodeGenerator\ClassResolver;

/**
 * An interface to get an instance of a class with dependency injection.
 */
interface ClassResolverInterface {

  /**
   * Returns a class instance with a given class name.
   *
   * @param string $class
   *   A class name.
   *
   * @return object
   *   The instance of the class.
   *
   * @throws \InvalidArgumentException
   *   If the class does not exist.
   */
  public function getInstance(string $class): object;

}
