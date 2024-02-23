<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Validator;

/**
 * Validates required machine name.
 */
final class MachineName {

  /**
   * @throws \UnexpectedValueException
   */
  public function __invoke(mixed $value): string {
    if (!\is_string($value) || !\preg_match('/^[a-z][a-z0-9_]*[a-z0-9]$/', $value)) {
      throw new \UnexpectedValueException('The value is not correct machine name.');
    }
    return $value;
  }

}
