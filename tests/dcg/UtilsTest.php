<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Tests for a Utils class.
 */
final class UtilsTest extends BaseTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    (new Filesystem())->dumpFile($this->directory . '/foo/foo.info.yml', 'Content.');
  }

  /**
   * Test callback.
   *
   * @covers \DrupalCodeGenerator\Utils::machine2human
   * @dataProvider machineToHumanProvider
   */
  public function testMachineToHuman(string $machine_name, string $expected_human_name, bool $title_case): void {
    self::assertEquals($expected_human_name, Utils::machine2human($machine_name, $title_case));
  }

  /**
   * Data provider callback for testMachineToHuman().
   */
  public function machineToHumanProvider(): array {
    return [
      ['hello_world', 'Hello world', FALSE],
      ['_hello_world_', 'Hello World', TRUE],
      ['__123', '123', TRUE],
    ];
  }

  /**
   * Test callback.
   *
   * @covers \DrupalCodeGenerator\Utils::human2machine
   * @dataProvider human2machineProvider
   */
  public function testHumanToMachine(string $human_name, string $expected_machine_name): void {
    self::assertEquals($expected_machine_name, Utils::human2machine($human_name));
  }

  /**
   * Data provider callback for testMachineToHuman().
   */
  public function human2machineProvider(): array {
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
   * @covers \DrupalCodeGenerator\Utils::camel2machine
   * @dataProvider camel2machineProvider
   */
  public function testCamelToMachine(string $camel_input, string $expected_machine_name): void {
    self::assertEquals($expected_machine_name, Utils::camel2machine($camel_input));
  }

  /**
   * Data provider callback for testCamelToMachine().
   */
  public function camel2machineProvider(): array {
    return [
      ['HelloWorld!', 'hello_world'],
      ['lowerCamel', 'lower_camel'],
      ['_xXx_', 'x_xx'],
    ];
  }

  /**
   * Test callback.
   *
   * @covers \DrupalCodeGenerator\Utils::camelize
   * @dataProvider camelizeProvider
   */
  public function testCamelize(string $text, bool $upper_camel, string $expected): void {
    self::assertEquals($expected, Utils::camelize($text, $upper_camel));
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
   * @covers \DrupalCodeGenerator\Utils::getExtensionRoot
   * @dataProvider getExtensionRootProvider
   */
  public function testGetExtensionRoot(string $target_directory, $expected_extension_root): void {
    $extension_root = Utils::getExtensionRoot($target_directory);
    self::assertEquals($expected_extension_root, $extension_root);
  }

  /**
   * Data provider callback for testGetExtensionRoot().
   */
  public function getExtensionRootProvider(): array {
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
  public function testReplaceTokens(string $input, array $vars, string $expected_output, bool $exception = FALSE): void {
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
      ['-=\{foo\}=-', ['foo' => 'bar'], '-=\{foo\}=-'],
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
   * @covers \DrupalCodeGenerator\Utils::testAddSlashes()
   */
  public function testAddSlashes(): void {
    self::assertEquals('foo \{node\} bar', Utils::addSlashes('foo {node} bar'));
  }

  /**
   * Test callback.
   *
   * @covers \DrupalCodeGenerator\Utils::testAddSlashes()
   */
  public function testStripSlashes(): void {
    self::assertEquals('foo {node} bar', Utils::stripSlashes('foo \{node\} bar'));
  }

  /**
   * Test callback.
   *
   * @covers \DrupalCodeGenerator\Utils::pluralize()
   */
  public function testPluralize(): void {
    self::assertEquals('cats', Utils::pluralize('cat'));
    self::assertEquals('flies', Utils::pluralize('fly'));
    self::assertEquals('bosses', Utils::pluralize('boss'));
    self::assertEquals('mice', Utils::pluralize('mouse'));
  }

}
