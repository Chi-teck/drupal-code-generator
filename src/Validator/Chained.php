<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Validator;

/**
 * Validates PHP class name.
 */
final class Chained {

  readonly private array $validators;

  public function __construct(callable ...$validators) {
    $this->validators = $validators;
  }

  public function __invoke(mixed $value): mixed {
    foreach ($this->validators as $validator) {
      $value = $validator($value);
    }
    return $value;
  }

}
