<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Tests for a Utils class.
 */
class UtilsTest extends TestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    (new Filesystem())->dumpFile($this->directory . '/foo/foo.info.yml', 'Content.');
  }

  /**
   * Test callback.
   *
   * @param string $machine_name
   *   Module machine name.
   * @param string $plugin_label
   *   Plugin label.
   * @param string $expected_plugin_id
   *   Expected default plugin ID.
   *
   * @covers \DrupalCodeGenerator\Utils::defaultPluginId
   * @dataProvider defaultPluginIdProvider
   */
  public function testDefaultPluginId($machine_name, $plugin_label, $expected_plugin_id) {
    $vars = [
      'machine_name' => $machine_name,
      'plugin_label' => $plugin_label,
    ];
    static::assertEquals($expected_plugin_id, Utils::defaultPluginId($vars));
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
   * @param string $machine_name
   *   Machine name to process.
   * @param string $expected_human_name
   *   Expected human name.
   *
   * @covers \DrupalCodeGenerator\Utils::machine2human
   * @dataProvider machineToHumanProvider
   */
  public function testMachineToHuman($machine_name, $expected_human_name) {
    static::assertEquals($expected_human_name, Utils::machine2human($machine_name));
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
   * @param string $human_name
   *   Human name to process.
   * @param string $expected_machine_name
   *   Expected machine name.
   *
   * @covers \DrupalCodeGenerator\Utils::human2machine
   * @dataProvider human2machineProvider
   */
  public function testHumanToMachine($human_name, $expected_machine_name) {
    static::assertEquals($expected_machine_name, Utils::human2machine($human_name));
  }

  /**
   * Data provider callback for testMachineToHuman().
   */
  public function human2machineProvider() {
    return [
      ['Hello world!', 'hello_world'],
      ['Camel Case Here', 'camel_case_here'],
      [' &*^*()@#a*&)(&*0b@#$$() c  !', 'a_0b_c'],
      ['12345abc', 'abc'],
      ['12345', ''],
    ];
  }

  /**
   * Test callback.
   *
   * @param string $text
   *   Text to camelize.
   * @param string $upper_camel
   *   Indicates if the first letter should be in upper case.
   * @param string $expected
   *   Expected result.
   *
   * @covers \DrupalCodeGenerator\Utils::camelize
   * @dataProvider camelizeProvider
   */
  public function testCamelize($text, $upper_camel, $expected) {
    static::assertEquals($expected, Utils::camelize($text, $upper_camel));
  }

  /**
   * Data provider callback for testHuman2class().
   */
  public function camelizeProvider() {
    return [
      ['Hello world!', TRUE, 'HelloWorld'],
      ['snake_case_here', TRUE, 'SnakeCaseHere'],
      ['snake_case_here', FALSE, 'snakeCaseHere'],
      ['train-case-here', TRUE, 'TrainCaseHere'],
      ['dot.case.here', FALSE, 'dotCaseHere'],
      ['foo', TRUE, 'Foo'],
      [' &*^*()@#a*&)(&*0b@#$$() c  ! ', TRUE, 'A0bC'],
      ['Zx%ABcDDD123 ', FALSE, 'zxAbcDdd123'],
    ];
  }

  /**
   * Test callback.
   *
   * @param string $machine_name
   *   Machine name to validate.
   * @param \UnexpectedValueException|null $exception
   *   Expected exception.
   *
   * @covers \DrupalCodeGenerator\Utils::validateMachineName
   * @dataProvider validateMachineNameProvider
   */
  public function testValidateMachineName($machine_name, $exception) {
    if ($exception) {
      $this->expectException(get_class($exception));
      $this->expectExceptionMessage($exception->getMessage());
    }
    static::assertEquals($machine_name, Utils::validateMachineName($machine_name));
  }

  /**
   * Data provider callback for testValidateMachineName().
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateMachineNameProvider() {
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
   * @covers \DrupalCodeGenerator\Utils::validateClassName
   * @dataProvider validateClassNameProvider
   */
  public function testValidateClassName($class_name, $exception) {
    if ($exception) {
      $this->expectException(get_class($exception));
      $this->expectExceptionMessage($exception->getMessage());
    }
    static::assertEquals($class_name, Utils::validateClassName($class_name));
  }

  /**
   * Data provider callback for testValidateClassName().
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateClassNameProvider() {
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
   * @param mixed $value
   *   The value to validate.
   * @param \UnexpectedValueException|null $exception
   *   Expected exception.
   *
   * @covers \DrupalCodeGenerator\Utils::validateRequired
   * @dataProvider validateRequiredProvider
   */
  public function testValidateRequired($value, $exception) {
    if ($exception) {
      $this->expectException(get_class($exception));
      $this->expectExceptionMessage($exception->getMessage());
    }
    static::assertEquals($value, Utils::validateRequired($value));
  }

  /**
   * Data provider callback for testValidateRequired().
   *
   * @return array
   *   Array of arguments of test callback.
   */
  public function validateRequiredProvider() {
    $exception = new \UnexpectedValueException('The value is required.');
    return [
      ['yes', NULL],
      ['0', NULL],
      [0, NULL],
      [FALSE, NULL],
      ['', $exception],
      [NULL, $exception],
    ];
  }

  /**
   * Test callback.
   *
   * @param string $target_directory
   *   Directory for which the extension root is checked.
   * @param string|bool $expected_extension_root
   *   Expected extension root or FALSE if root directory should not be found.
   *
   * @covers \DrupalCodeGenerator\Utils::getExtensionRoot
   * @dataProvider getExtensionRootProvider
   */
  public function testGetExtensionRoot($target_directory, $expected_extension_root) {
    $extension_root = Utils::getExtensionRoot($target_directory);
    self::assertEquals($expected_extension_root, $extension_root);
  }

  /**
   * Data provider callback for testGetExtensionRoot().
   */
  public function getExtensionRootProvider() {
    $extension_root = sys_get_temp_dir() . '/dcg_sandbox/foo';
    return [
      ['/tmp', FALSE],
      [$extension_root, $extension_root],
      [$extension_root . '/src', $extension_root],
      [$extension_root . '/src/Plugin', $extension_root],
      [$extension_root . '/src/Plugin/Block', $extension_root],
    ];
  }

  /**
   * Test callback.
   *
   * @covers \DrupalCodeGenerator\Utils::defaultQuestions
   */
  public function testDefaultQuestions() {
    $questions = $this->defaultQuestions();
    static::assertEquals($questions, Utils::defaultQuestions());
  }

  /**
   * Test callback.
   *
   * @covers \DrupalCodeGenerator\Utils::defaultPluginQuestions
   */
  public function testDefaultPluginQuestions() {
    $questions = $this->defaultPluginQuestions();
    static::assertEquals($questions, Utils::defaultPluginQuestions());
  }

  /**
   * Returns default questions.
   *
   * @return array
   *   Array of default questions.
   */
  protected function defaultQuestions() {
    $questions['name'] = new Question('Module name');
    $questions['name']->setValidator([Utils::class, 'validateRequired']);
    $questions['machine_name'] = new Question('Module machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);
    return $questions;
  }

  /**
   * Returns default plugin questions.
   *
   * @return array
   *   Array of default plugin questions.
   */
  protected function defaultPluginQuestions() {
    $questions = $this->defaultQuestions();
    $questions['plugin_label'] = new Question('Plugin label', 'Example');
    $questions['plugin_label']->setValidator([Utils::class, 'validateRequired']);
    $questions['plugin_id'] = new Question('Plugin ID', [Utils::class, 'defaultPluginId']);
    $questions['plugin_id']->setValidator([Utils::class, 'validateMachineName']);
    return $questions;
  }

  /**
   * Test callback.
   *
   * @covers \DrupalCodeGenerator\Utils::tokenReplace()
   */
  public function testTokenReplace() {
    static::assertEquals('-=bar=-', Utils::tokenReplace('-={foo}=-', ['foo' => 'bar']));
  }

}
