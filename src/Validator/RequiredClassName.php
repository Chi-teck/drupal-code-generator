<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Validator;

/**
 * Validates required PHP class name.
 */
final class RequiredClassName {

  /**
   * @throws \UnexpectedValueException
   */
  public function __invoke(mixed $value): string {
    return (new Chained(new Required(), new ClassName()))($value);
  }

}
