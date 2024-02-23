<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Validator;

/**
 * Validates required service name.
 */
final class RequiredServiceName {

  /**
   * @throws \UnexpectedValueException
   */
  public function __invoke(mixed $value): string {
    return (new Chained(new Required(), new ServiceName()))($value);
  }

}
