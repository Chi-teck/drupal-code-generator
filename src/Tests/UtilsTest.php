<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Utils;

/**
 * Tests for a Utils class.
 */
class UtilsTest extends \PHPUnit_Framework_TestCase {

  /**
   * Test callback.
   *
   * @covers Utils::defaultPluginId
   * @dataProvider defaultPluginIdProvider
   */
  public function testDefaultPluginId($machine_name, $plugin_label, $expected) {
    $vars = [
      'machine_name' => $machine_name,
      'plugin_label' => $plugin_label,
    ];
    $this->assertEquals($expected, Utils::defaultPluginId($vars));
  }

  /**
   * Data provider callback for testDefaultPluginId().
   */
  public function defaultPluginIdProvider() {
    return [
      ['foo', 'Hello world', 'foo_hello_world'],
      ['bar', 'Ok*123', 'bar_ok_123'],
      ['abc', ' Hello world - %^$&*(^()& !', 'abc_hello_world'],
    ];
  }

  /**
   * Test callback.
   *
   * @covers Utils::machine2human
   * @dataProvider machineToHumanProvider
   */
  public function testMachineToHuman($machine_name, $expected) {
    $this->assertEquals($expected, Utils::machine2human($machine_name));
  }

  /**
   * Data provider callback for testMachineToHuman().
   */
  public function machineToHumanProvider() {
    return [
      ['hello_world', 'Hello world'],
      ['_hello_world_', 'Hello world'],
      ['__123', '123'],
    ];
  }

  /**
   * Test callback.
   *
   * @covers Utils::human2machine
   * @dataProvider human2machineProvider
   */
  public function testHumanToMachine($human_name, $expected) {
    $this->assertEquals($expected, Utils::human2machine($human_name));
  }

  /**
   * Data provider callback for testMachineToHuman().
   */
  public function human2machineProvider() {
    return [
      ['Hello world!', 'hello_world'],
      ['Camel Case Here', 'camel_case_here'],
      [' &*^*()@#a*&)(&*0b@#$$() c  !', 'a_0b_c'],
    ];
  }

  /**
   * Test callback.
   *
   * @covers Utils::human2class
   * @dataProvider human2classProvider
   */
  public function testHuman2class($human_name, $expected) {
    $this->assertEquals($expected, Utils::human2class($human_name));
  }

  /**
   * Data provider callback for testHuman2class().
   */
  public function human2classProvider() {
    return [
      ['Hello world!', 'HelloWorld'],
      ['snake_case_here', 'SnakeCaseHere'],
      [' &*^*()@#a*&)(&*0b@#$$() c  ! ', 'a0bC'],
    ];
  }

  /**
   * Test callback.
   *
   * @covers Utils::validateMachineName
   * @dataProvider validateMachineNameProvider
   */
  public function testValidateMachineName($human_name, $expected) {
    $this->assertEquals($expected, Utils::validateMachineName($human_name));
  }

  /**
   * Data provider callback for testValidateMachineName().
   */
  public function validateMachineNameProvider() {
    $error = 'The value is not correct machine name.';
    return [
      ['snake_case_here', NULL],
      [' not_trimmed ', $error],
      ['Hello world ', $error],
      ['foo_', $error],
      ['', $error],
      ['foo*&)(*&@#()*&@#bar', $error],
    ];
  }

  /**
   * Test callback.
   *
   * @covers Utils::validateClassName
   * @dataProvider validateClassNameProvider
   */
  public function testValidateClassName($human_name, $expected) {
    $this->assertEquals($expected, Utils::validateClassName($human_name));
  }

  /**
   * Data provider callback for testValidateClassName().
   */
  public function validateClassNameProvider() {
    $error = 'The value is not correct class name.';
    return [
      ['GoodClassName', NULL],
      ['snake_case_here', $error],
      [' NotTrimmed ', $error],
      ['With_Underscore', $error],
      ['WrongSymbols@)@#&)', $error],
    ];
  }

  /**
   * Test callback.
   *
   * @covers Utils::validateRequired
   * @dataProvider validateRequiredProvider
   */
  public function testValidateRequired($human_name, $expected) {
    $this->assertEquals($expected, Utils::validateRequired($human_name));
  }

  /**
   * Data provider callback for testValidateRequired().
   */
  public function validateRequiredProvider() {
    $error = 'The value is required.';
    return [
      ['yes', NULL],
      ['0', NULL],
      [0, NULL],
      [FALSE, NULL],
      ['', $error],
      [NULL, $error],
    ];
  }

  /**
   * Test callback.
   *
   * @covers Utils::normalizePath
   * @dataProvider vtestNormalizePathProvider
   */
  public function testNormalizePath($human_name, $expected) {
    $this->assertEquals($expected, Utils::normalizePath($human_name));
  }

  /**
   * Data provider callback for testNormalizePath().
   */
  public function testNormalizePathProvider() {
    return [
      ['/var/www/test', '/var/www/test'],
      ['./test', 'test'],
      ['../test', '../test'],
      ['../test/abc/../foo', '../test/foo'],
      ['..\test/abc\../../bar/../foo', '../foo'],
    ];
  }

  /**
   * Test callback.
   *
   * @covers Utils::defaultQuestions
   */
  public function testDefaultQuestions() {
    $expected = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
    ];
    $this->assertEquals($expected, Utils::defaultQuestions());
  }

}
