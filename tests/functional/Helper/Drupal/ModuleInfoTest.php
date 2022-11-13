<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional;

use DrupalCodeGenerator\Helper\Drupal\ModuleInfo;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;
use DrupalCodeGenerator\Utils;

/**
 * Tests 'module info' helper.
 */
final class ModuleInfoTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function testGetName(): void {
    $module_info = new ModuleInfo(self::bootstrap()->get('module_handler'));
    self::assertSame('module_info', $module_info->getName());
  }

  /**
   * Test callback.
   */
  public function testGetModules(): void {
    $module_info = new ModuleInfo(self::bootstrap()->get('module_handler'));

    $modules = $module_info->getExtensions();
    // Full list of modules is rather long and may vary depending on`
    // environment.
    self::assertSame('Custom Block', $modules['block_content']);
    self::assertSame('Database Logging', $modules['dblog']);
    self::assertSame('Options', $modules['options']);
    self::assertSame('Views', $modules['views']);
  }

  /**
   * Test callback.
   */
  public function testGetDestination(): void {
    $module_info = new ModuleInfo(self::bootstrap()->get('module_handler'));

    self::assertDestination('modules', $module_info->getDestination('node', TRUE));
    self::assertDestination('core/modules/node', $module_info->getDestination('node', FALSE));
    self::assertDestination('modules', $module_info->getDestination('foo', TRUE));
    self::assertDestination('modules/foo', $module_info->getDestination('foo', FALSE));
  }

  /**
   * Test callback.
   */
  public function testGetModuleName(): void {
    $module_info = new ModuleInfo(self::bootstrap()->get('module_handler'));

    self::assertSame('Database Logging', $module_info->getExtensionName('dblog'));
    self::assertNull($module_info->getExtensionName('unknown_module'));
  }

  /**
   * Test callback.
   */
  public function testGetModuleMachineName(): void {
    $module_info = new ModuleInfo(self::bootstrap()->get('module_handler'));

    self::assertSame('dblog', $module_info->getExtensionMachineName('Database Logging'));
    self::assertNull($module_info->getExtensionName('Unknown Module'));
  }

  /**
   * Test callback.
   */
  public function testGetExtensionFromPath(): void {
    $module_info = new ModuleInfo(self::bootstrap()->get('module_handler'));

    $module = $module_info->getExtensionFromPath(\DRUPAL_ROOT . '/core/modules/node');
    self::assertSame('node', $module->getName());

    $module = $module_info->getExtensionFromPath(\DRUPAL_ROOT . '/core/modules/node/src/Plugin');
    self::assertSame('node', $module->getName());

    $module = $module_info->getExtensionFromPath(\DRUPAL_ROOT . '/core/modules');
    self::assertNull($module);

    self::expectExceptionObject(new \InvalidArgumentException('The path must be absolute.'));
    $module_info->getExtensionFromPath('relative/path');
  }

  /**
   * Asserts destination.
   */
  private static function assertDestination(string $expected, string $actual): void {
    self::assertSame($expected, Utils::removePrefix($actual, \DRUPAL_ROOT . '/'));
  }

}
