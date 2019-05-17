<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Tests for a Utils class.
 */
class UtilsTest extends BaseTestCase {

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
   * @param string $camel_input
   *   Camel string to process.
   * @param string $expected_machine_name
   *   Expected machine name.
   *
   * @covers \DrupalCodeGenerator\Utils::camel2machine
   * @dataProvider camel2machineProvider
   */
  public function testCamelToMachine($camel_input, $expected_machine_name) {
    static::assertEquals($expected_machine_name, Utils::camel2machine($camel_input));
  }

  /**
   * Data provider callback for testCamelToMachine().
   */
  public function camel2machineProvider() {
    return [
      ['HelloWorld!', 'hello_world'],
      ['lowerCamel', 'lower_camel'],
      ['_xXx_', 'x_xx'],
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
   * @covers \DrupalCodeGenerator\Utils::replaceTokens()
   * @dataProvider replaceTokensProvider
   */
  public function testReplaceTokens($input, $vars, $expected_output, bool $exception = FALSE) :void {
    if ($exception) {
      self::expectException(\UnexpectedValueException::class);
      self::expectExceptionMessage($expected_output);
      Utils::replaceTokens($input, $vars);
    }
    else {
      self::assertEquals($expected_output, Utils::replaceTokens($input, $vars));
    }
  }

  /**
   * Data provider callback for testReplaceTokens().
   */
  public function replaceTokensProvider() :array {
    return [
      ['-={foo}=-', ['foo' => 'bar'], '-=bar=-'],
      ['-={foo|camelize}=-', ['foo' => 'bar'], '-=Bar=-'],
      ['-={foo|u2h}=-', ['foo' => 'alpha_beta'], '-=alpha-beta=-'],
      ['-={foo|h2u}=-', ['foo' => 'alpha-beta'], '-=alpha_beta=-'],
      ['-={foo|h2m}=-', ['foo' => 'Alpha beta'], '-=alpha_beta=-'],
      ['-={foo|m2h}=-', ['foo' => 'alpha_beta'], '-=Alpha beta=-'],
      ['-={foo|c2m}=-', ['foo' => 'AlphaBeta'], '-=alpha_beta=-'],
      [
        '-={foo|h2u|camelize}=-',
        ['foo' => 'alpha-beta'],
        'Filter "h2u|camelize" is not defined',
        TRUE,
      ],
      [
        '-={foo|wrong}=-',
        ['foo' => 'alpha-beta'],
        'Filter "wrong" is not defined',
        TRUE,
      ],
    ];
  }

  /**
   * Test callback.
   *
   * @covers \DrupalCodeGenerator\Utils::pluralize()
   */
  public function testPluralize() {
    static::assertEquals('cats', Utils::pluralize('cat'));
    static::assertEquals('flies', Utils::pluralize('fly'));
    static::assertEquals('bosses', Utils::pluralize('boss'));
  }

}
