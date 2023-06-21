<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Validator;

/**
 * Validates required permission name.
 */
final class RequiredPermissionName {

  /**
   * @throws \UnexpectedValueException
   */
  public function __invoke(mixed $value): string {
    return (new Chained(new Required(), new PermissionName()))($value);
  }

}
