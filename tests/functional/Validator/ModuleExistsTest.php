<?php declare(strict_types = 1);

namespace Validator;

use DrupalCodeGenerator\Helper\Drupal\ModuleInfo;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;
use DrupalCodeGenerator\Validator\ModuleExists;

/**
 * Tests ModuleExists validator.
 */
final class ModuleExistsTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function test(): void {
    $module_handler = self::bootstrap()->get('module_handler');
    $validator = new ModuleExists(new ModuleInfo($module_handler));

    self::assertSame('node', $validator('node'));
    self::assertSame('filter', $validator('filter'));
    self::expectExceptionObject(new \UnexpectedValueException('Module does not exists.'));
    $validator('ban');
  }

}
