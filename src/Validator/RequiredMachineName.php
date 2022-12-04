<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Validator;

/**
 * Validates required machine name.
 */
final class RequiredMachineName {

  /**
   * @throws \UnexpectedValueException
   */
  public function __invoke(mixed $value): string {
    return (new Chained(new Required(), new MachineName()))($value);
  }

}
