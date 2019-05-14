<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\ValidatorTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests for a Validator class.
 */
class ValidatorTraitTest extends TestCase {

  /**
   * Validator instance.
   *
   * @var \DrupalCodeGenerator\Command\Generator
   */
  private $validator;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->validator = new class() {
      use ValidatorTrait;
    };
  }

  /**
   * Test callback.
   *
   * @param string $machine_name
   *   Machine name to validate.
   * @param bool $exception
   *   Indicates that an exception is expected.
   *
   * @dataProvider validateMachineNameProvider()
   */
  public function testValidateMachineName($machine_name, bool $exception) :void {
    if ($exception) {
      $this->expectException(\UnexpectedValueException::class);
      $this->expectExceptionMessage('The value is not correct machine name.');
    }
    self::assertEquals($machine_name, $this->validator::validateMachineName($machine_name));
  }

  /**
   * Data provider callback for testValidateMachineName().
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateMachineNameProvider() :array {
    return [
      ['snake_case_here', FALSE],
      ['snake_case_here123', FALSE],
      [' not_trimmed ', TRUE],
      ['Hello world ', TRUE],
      ['foo_', TRUE],
      ['', TRUE],
      ['foo*&)(*&@#()*&@#bar', TRUE],
    ];
  }

  /**
   * Test callback.
   *
   * @param string $class_name
   *   Class name to validate.
   * @param bool $exception
   *   Indicates that an exception is expected.
   *
   * @dataProvider validateClassNameProvider()
   */
  public function testValidateClassName($class_name, bool $exception) :void {
    if ($exception) {
      $this->expectException(\UnexpectedValueException::class);
      $this->expectExceptionMessage('The value is not correct class name.');
    }
    self::assertEquals($class_name, $this->validator::validateClassName($class_name));
  }

  /**
   * Data provider callback for testValidateClassName().
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateClassNameProvider() :array {
    return [
      ['GoodClassName', FALSE],
      ['snake_case_here', TRUE],
      [' NotTrimmed ', TRUE],
      ['With_Underscore', TRUE],
      ['WrongSymbols@)@#&)', TRUE],
    ];
  }

  /**
   * Test callback.
   *
   * @param string $service_name
   *   Service name to validate.
   * @param bool $exception
   *   Indicates that an exception is expected.
   *
   * @dataProvider validateServiceNameProvider()
   */
  public function testValidateServiceName($service_name, bool $exception) :void {
    if ($exception) {
      $this->expectException(\UnexpectedValueException::class);
      $this->expectExceptionMessage('The value is not correct service name.');
    }
    self::assertEquals($service_name, $this->validator::validateServiceName($service_name));
  }

  /**
   * Data provider callback for testValidateServiceName().
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateServiceNameProvider() :array {
    return [
      ['CamelCaseHere', TRUE],
      ['snake_case_here', FALSE],
      [' not_trimmed ', TRUE],
      ['dot.inside', FALSE],
      ['.leading.dot', TRUE],
      ['ending.dot.', TRUE],
      ['special&character', TRUE],
    ];
  }

  /**
   * Test callback.
   *
   * @param mixed $value
   *   The value to validate.
   * @param bool $exception
   *   Indicates that an exception is expected.
   *
   * @dataProvider validateRequiredProvider()
   */
  public function testValidateRequired($value, bool $exception) :void {
    if ($exception) {
      $this->expectException(\UnexpectedValueException::class);
      $this->expectExceptionMessage('The value is required.');
    }
    self::assertEquals($value, $this->validator::validateRequired($value));
  }

  /**
   * Data provider callback for testValidateRequired().
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateRequiredProvider() :array {
    return [
      ['yes', FALSE],
      ['0', FALSE],
      [0, FALSE],
      ['', TRUE],
      [NULL, TRUE],
    ];
  }

}
