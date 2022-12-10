<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Validator;

/**
 * Validates only non-empty values.
 */
final class Optional {

  private readonly \Closure $validator;

  /**
   * @psalm-param callable(mixed): mixed $validator
   */
  public function __construct(callable $validator) {
    // Convert into closure as typed properties cannot be callable.
    $this->validator = $validator(...);
  }

  /**
   * @throws \UnexpectedValueException
   */
  public function __invoke(mixed $value): mixed {
    return $value === NULL || $value === '' || $value === [] ? $value : ($this->validator)($value);
  }

}
