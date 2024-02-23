<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Validator;

/**
 * Validates whether a value match or not given regexp pattern.
 */
final class RegExp {

  /**
   * @psalm-param non-empty-string $pattern
   */
  public function __construct(
    private readonly string $pattern,
    private readonly ?string $message = NULL,
  ) {}

  /**
   * @throws \UnexpectedValueException
   */
  public function __invoke(mixed $value): string {
    if (!\is_string($value) || !\preg_match($this->pattern, $value)) {
      $message = $this->message ?? \sprintf('The value does not match pattern "%s".', $this->pattern);
      throw new \UnexpectedValueException($message);
    }
    return $value;
  }

}
