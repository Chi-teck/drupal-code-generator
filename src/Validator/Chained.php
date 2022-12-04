<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Validator;

/**
 * Validates PHP class name.
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

}
