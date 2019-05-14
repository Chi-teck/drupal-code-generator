<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Utils\Validator;

/**
 * Tests for a Validator class.
 */
class ValidatorTest extends BaseTestCase {

  /**
   * Test callback.
   *
   * @param string $machine_name
   *   Machine name to validate.
   * @param \UnexpectedValueException|null $exception
   *   Expected exception.
   *
   * @dataProvider validateMachineNameProvider()
   */
  public function testValidateMachineName($machine_name, ?\UnexpectedValueException $exception) :void {
    if ($exception) {
      $this->expectException(get_class($exception));
      $this->expectExceptionMessage($exception->getMessage());
    }
    self::assertEquals($machine_name, Validator::validateMachineName($machine_name));
  }

  /**
   * Data provider callback for testValidateMachineName().
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateMachineNameProvider() :array {
    $exception = new \UnexpectedValueException('The value is not correct machine name.');
    return [
      ['snake_case_here', NULL],
      ['snake_case_here123', NULL],
      [' not_trimmed ', $exception],
      ['Hello world ', $exception],
      ['foo_', $exception],
      ['', $exception],
      ['foo*&)(*&@#()*&@#bar', $exception],
    ];
  }

  /**
   * Test callback.
   *
   * @param string $class_name
   *   Class name to validate.
   * @param \UnexpectedValueException|null $exception
   *   Expected exception.
   *
   * @dataProvider validateClassNameProvider()
   */
  public function testValidateClassName($class_name, ?\UnexpectedValueException $exception) :void {
    if ($exception) {
      $this->expectException(get_class($exception));
      $this->expectExceptionMessage($exception->getMessage());
    }
    self::assertEquals($class_name, Validator::validateClassName($class_name));
  }

  /**
   * Data provider callback for testValidateClassName().
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateClassNameProvider() :array {
    $exception = new \UnexpectedValueException('The value is not correct class name.');
    return [
      ['GoodClassName', NULL],
      ['snake_case_here', $exception],
      [' NotTrimmed ', $exception],
      ['With_Underscore', $exception],
      ['WrongSymbols@)@#&)', $exception],
    ];
  }

  /**
   * Test callback.
   *
   * @param string $service_name
   *   Service name to validate.
   * @param \UnexpectedValueException|null $exception
   *   Expected exception.
   *
   * @dataProvider validateServiceNameProvider()
   */
  public function testValidateServiceName($service_name, ?\UnexpectedValueException $exception) :void {
    if ($exception) {
      $this->expectException(get_class($exception));
      $this->expectExceptionMessage($exception->getMessage());
    }
    self::assertEquals($service_name, Validator::validateServiceName($service_name));
  }

  /**
   * Data provider callback for testValidateServiceName().
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateServiceNameProvider() :array {
    $exception = new \UnexpectedValueException('The value is not correct service name.');
    return [
      ['CamelCaseHere', $exception],
      ['snake_case_here', NULL],
      [' not_trimmed ', $exception],
      ['dot.inside', NULL],
      ['.leading.dot', $exception],
      ['ending.dot.', $exception],
      ['special&character', $exception],
    ];
  }

  /**
   * Test callback.
   *
   * @param mixed $value
   *   The value to validate.
   * @param \UnexpectedValueException|null $exception
   *   Expected exception.
   *
   * @dataProvider validateRequiredProvider()
   */
  public function testValidateRequired($value, ?\UnexpectedValueException $exception) :void {
    if ($exception) {
      $this->expectException(get_class($exception));
      $this->expectExceptionMessage($exception->getMessage());
    }
    self::assertEquals($value, Validator::validateRequired($value));
  }

  /**
   * Data provider callback for testValidateRequired().
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateRequiredProvider() :array {
    $exception = new \UnexpectedValueException('The value is required.');
    return [
      ['yes', NULL],
      ['0', NULL],
      [0, NULL],
      ['', $exception],
      [NULL, $exception],
    ];
  }

}
