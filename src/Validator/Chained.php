<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Validator;

/**
 * Validates using a chain of validators.
 */
final class Chained {

  private readonly array $validators;

  /**
   * @psalm-param callable(mixed): mixed ...$validators
   */
  public function __construct(callable ...$validators) {
    $this->validators = $validators;
  }

  /**
   * @throws \UnexpectedValueException
   */
  public function __invoke(mixed $value): mixed {
    foreach ($this->validators as $validator) {
      $value = $validator($value);
    }
    return $value;
  }

  /**
   * Appends validators to the chain.
   */
  public function with(callable ...$validators): self {
    return new self(...$this->validators, ...$validators);
  }

}
