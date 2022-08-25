<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Validator;

/**
 * Validates that the value is one of the expected values.
 */
final class Choice {

  public function __construct(
    private readonly array $choices,
    private readonly string $message = 'The value you selected is not a valid choice.',
  ) {}

  public function __invoke(mixed $value): string|int|float {
    if (!\is_scalar($value) || !\in_array($value, $this->choices, TRUE)) {
      throw new \UnexpectedValueException($this->message);
    }
    return $value;
  }

}
