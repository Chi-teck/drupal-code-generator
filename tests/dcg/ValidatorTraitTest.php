<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Command\GeneratorInterface;
use DrupalCodeGenerator\ValidatorTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests for a Validator class.
 */
final class ValidatorTraitTest extends TestCase {

  /**
   * Validator instance.
   *
   * @var \DrupalCodeGenerator\Command\Generator
   */
  private GeneratorInterface $validator;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    $this->validator = new class() implements GeneratorInterface {
      use ValidatorTrait;

      /**
       * {@inheritdoc}
       */
      public function getLabel(): string {
        return '';
      }

      /**
       * {@inheritdoc}
       */
      public static function getApi(): int {
        return 2;
      }

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
  public function testValidateMachineName(string $machine_name, bool $exception): void {
    if ($exception) {
      $this->expectException(\UnexpectedValueException::class);
      $this->expectExceptionMessage('The value is not correct machine name.');
    }
    self::assertSame($machine_name, $this->validator::validateMachineName($machine_name));
  }

  /**
   * Data provider.
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateMachineNameProvider(): array {
    return [
      ['snake_case_here', FALSE],
      ['snake_case_here123', FALSE],
      [' not_trimmed ', TRUE],
      ['Hello world ', TRUE],
      ['foo_', TRUE],
      ['', FALSE],
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
  public function testValidateClassName(string $class_name, bool $exception): void {
    if ($exception) {
      $this->expectException(\UnexpectedValueException::class);
      $this->expectExceptionMessage('The value is not correct class name.');
    }
    self::assertSame($class_name, $this->validator::validateClassName($class_name));
  }

  /**
   * Data provider.
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateClassNameProvider(): array {
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
  public function testValidateServiceName(string $service_name, bool $exception): void {
    if ($exception) {
      $this->expectException(\UnexpectedValueException::class);
      $this->expectExceptionMessage('The value is not correct service name.');
    }
    self::assertSame($service_name, $this->validator::validateServiceName($service_name));
  }

  /**
   * Data provider.
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateServiceNameProvider(): array {
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
  public function testValidateRequired($value, bool $exception): void {
    if ($exception) {
      $this->expectException(\UnexpectedValueException::class);
      $this->expectExceptionMessage('The value is required.');
    }
    self::assertEquals($value, $this->validator::validateRequired($value));
  }

  /**
   * Data provider.
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateRequiredProvider(): array {
    return [
      ['yes', FALSE],
      ['0', FALSE],
      ['', TRUE],
      [NULL, TRUE],
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
   * @dataProvider validateRequiredMachineNameProvider()
   */
  public function testValidateRequiredMachineName($value, bool $exception): void {
    if ($exception) {
      $this->expectException(\UnexpectedValueException::class);
      $this->expectExceptionMessage($value ? 'The value is not correct machine name.' : 'The value is required.');
    }
    self::assertSame($value, $this->validator::validateRequiredMachineName($value));
  }

  /**
   * Data provider..
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateRequiredMachineNameProvider(): array {
    return [
      ['test', FALSE],
      ['wrong machine name', TRUE],
      ['', TRUE],
      [NULL, TRUE],
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
   * @dataProvider validateRequiredClassNameProvider()
   */
  public function testValidateRequiredClassName($value, bool $exception): void {
    if ($exception) {
      $this->expectException(\UnexpectedValueException::class);
      $this->expectExceptionMessage($value ? 'The value is not correct class name.' : 'The value is required.');
    }
    self::assertSame($value, $this->validator::validateRequiredClassName($value));
  }

  /**
   * Data provider.
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateRequiredClassNameProvider(): array {
    return [
      ['GoodClassName', FALSE],
      ['wrong class name', TRUE],
      ['', TRUE],
      [NULL, TRUE],
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
   * @dataProvider validateRequiredServiceNameProvider()
   */
  public function testValidateRequiredServiceName($value, bool $exception): void {
    if ($exception) {
      $this->expectException(\UnexpectedValueException::class);
      $this->expectExceptionMessage($value ? 'The value is not correct service name.' : 'The value is required.');
    }
    self::assertSame($value, $this->validator::validateRequiredServiceName($value));
  }

  /**
   * Data provider.
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateRequiredServiceNameProvider(): array {
    return [
      ['good.service_name', FALSE],
      ['wrong class name', TRUE],
      ['', TRUE],
      [NULL, TRUE],
    ];
  }

}
