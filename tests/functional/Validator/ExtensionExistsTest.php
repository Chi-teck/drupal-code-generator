<?php declare(strict_types = 1);

namespace Validator;

use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Helper\Drupal\ModuleInfo;
use DrupalCodeGenerator\Helper\Drupal\ThemeInfo;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;
use DrupalCodeGenerator\Validator\ExtensionExists;

/**
 * Tests ServiceExists validator.
 */
final class ExtensionExistsTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function testModuleExists(): void {
    $module_handler = self::bootstrap()->get('module_handler');
    $validator = new ExtensionExists(new ModuleInfo($module_handler), GeneratorType::MODULE_COMPONENT);
    self::assertSame('node', $validator('node'));
    self::assertSame('filter', $validator('filter'));
    self::expectExceptionObject(new \UnexpectedValueException('Module "ban" does not exists.'));
    $validator('ban');
  }

  /**
   * Test callback.
   */
  public function testThemeExists(): void {
    $theme_handler = self::bootstrap()->get('theme_handler');
    $validator = new ExtensionExists(new ThemeInfo($theme_handler), GeneratorType::THEME_COMPONENT);
    self::assertSame('olivero', $validator('olivero'));
    self::assertSame('claro', $validator('claro'));
    self::expectExceptionObject(new \UnexpectedValueException('Theme "bartik" does not exists.'));
    $validator('bartik');
  }

  /**
   * Test callback.
   */
  public function testExtensionExists(): void {
    $module_handler = self::bootstrap()->get('module_handler');
    $validator = new ExtensionExists(new ModuleInfo($module_handler), GeneratorType::OTHER);
    self::assertSame('system', $validator('system'));
    self::assertSame('node', $validator('node'));
    self::expectExceptionObject(new \UnexpectedValueException('Extension "forum" does not exists.'));
    $validator('forum');
  }

}
