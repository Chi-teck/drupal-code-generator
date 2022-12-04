<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Validator;

/**
 * Validates PHP class name.
 */
final class ClassName {

  /**
   * @throws \UnexpectedValueException
   */
  public function __invoke(mixed $value): string {
    if (!\is_string($value) || !\preg_match('/^[A-Z][a-zA-Z0-9]+$/', $value)) {
      throw new \UnexpectedValueException('The value is not correct class name.');
    }
    return $value;
  }

}
