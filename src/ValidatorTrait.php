<?php declare(strict_types=1);

namespace DrupalCodeGenerator;

/**
 * Provides validators for console questions.
 */
trait ValidatorTrait {

  /**
   * Validates machine name.
   *
   * @param string|null $value
   *   A value to validate.
   *
   * @return string|null
   *   The validated value.
   *
   * @throws \UnexpectedValueException
   */
  public static function validateMachineName(?string $value): ?string {
    return static::validate($value, '^[a-z][a-z0-9_]*[a-z0-9]$', 'The value is not correct machine name.');
  }

  /**
   * Validates class name.
   *
   * @param string|null $value
   *   A value to validate.
   *
   * @return string|null
   *   The validated value.
   *
   * @see http://php.net/manual/en/language.oop5.basic.php
   */
  public static function validateClassName(?string $value): ?string {
    return static::validate($value, '^[A-Z][a-zA-Z0-9]+$', 'The value is not correct class name.');
  }

  /**
   * Validates service name.
   *
   * @param string|null $value
   *   A value to validate.
   *
   * @return string|null
   *   The validated value.
   */
  public static function validateServiceName(?string $value): ?string {
    return static::validate($value, '^[a-z][a-z0-9_\.]*[a-z0-9]$', 'The value is not correct service name.');
  }

  /**
   * Validates that the value is not empty.
   *
   * @param string|null $value
   *   A value to validate.
   *
   * @return string
   *   The validated value.
   *
   * @throws \UnexpectedValueException
   */
  public static function validateRequired(?string $value): string {
    // FALSE is not considered as empty value because question helper use
    // it as negative answer on confirmation questions.
    if ($value === NULL || $value === '') {
      throw new \UnexpectedValueException('The value is required.');
    }
    return $value;
  }

  /**
   * Validates required machine name.
   *
   * @param string|null $value
   *   A value to validate.
   *
   * @return string
   *   The validated value.
   */
  public static function validateRequiredMachineName(?string $value): string {
    $value = static::validateRequired($value);
    return static::validateMachineName($value);
  }

  /**
   * Validates required class name.
   *
   * @param string|null $value
   *   A value to validate.
   *
   * @return string
   *   The validated value.
   */
  public static function validateRequiredClassName(?string $value): string {
    $value = static::validateRequired($value);
    return static::validateClassName($value);
  }

  /**
   * Validates required service name.
   *
   * @param string|null $value
   *   A value to validate.
   *
   * @return string
   *   The validated value.
   */
  public static function validateRequiredServiceName(?string $value): string {
    $value = static::validateRequired($value);
    return static::validateServiceName($value);
  }

  /**
   * Validates a value with a given regular expression.
   *
   * @param string|null $value
   *   A value to validate.
   * @param string $pattern
   *   To pattern to search for.
   * @param string $message
   *   An exception message.
   *
   * @return string|null
   *   The validated value.
   */
  public static function validate(?string $value, string $pattern, string $message): ?string {
    if ($value !== '' && $value !== NULL && !\preg_match("/$pattern/", $value)) {
      throw new \UnexpectedValueException($message);
    }
    return $value;
  }

}
