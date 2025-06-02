<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Validator;

/**
 * Validates that the value is one of the expected values.
 */
final class Choice {

  public function __construct(
    private readonly array $choices,
    private readonly string $message = 'The value you selected is not a valid choice.',
  ) {}

  /**
   * @throws \UnexpectedValueException
   */
  public function __invoke(mixed $value): ?string {
    return match(FALSE) {
      \is_string($value) || \is_int($value) || \is_float($value),
      \in_array($value, $this->choices, TRUE) => $this->message,
      default => NULL,
    };
  }

}
