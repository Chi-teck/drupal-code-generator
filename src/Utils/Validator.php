<?php

namespace DrupalCodeGenerator\Utils;

/**
 * Provides validators for console questions.
 */
class Validator {

  /**
   * Machine name validator.
   */
  public static function validateMachineName(?string $value) :?string {
    if (!preg_match('/^[a-z][a-z0-9_]*[a-z0-9]$/', $value)) {
      throw new \UnexpectedValueException('The value is not correct machine name.');
    }
    return $value;
  }

  /**
   * Class name validator.
   *
   * @see http://php.net/manual/en/language.oop5.basic.php
   */
  public static function validateClassName(?string $value) :?string {
    if (!preg_match('/^[A-Z][a-zA-Z0-9]+$/', $value)) {
      throw new \UnexpectedValueException('The value is not correct class name.');
    }
    return $value;
  }

  /**
   * Service name validator.
   */
  public static function validateServiceName(?string $value) :?string {
    if ($value !== '' && $value !== NULL && !preg_match('/^[a-z][a-z0-9_\.]*[a-z0-9]$/', $value)) {
      throw new \UnexpectedValueException('The value is not correct service name.');
    }
    return $value;
  }

  /**
   * Required value validator.
   */
  public static function validateRequired(?string $value) :?string {
    // FALSE is not considered as empty value because question helper use
    // it as negative answer on confirmation questions.
    if ($value === NULL || $value === '') {
      throw new \UnexpectedValueException('The value is required.');
    }
    return $value;
  }

}
