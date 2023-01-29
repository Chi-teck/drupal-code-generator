<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Validator;

use DrupalCodeGenerator\Helper\Drupal\ServiceInfo;
use DrupalCodeGenerator\Test\Functional\FunctionalTestBase;
use DrupalCodeGenerator\Validator\ServiceExists;

/**
 * Tests ServiceExists validator.
 */
final class ServiceExistsTest extends FunctionalTestBase {

  /**
   * Test callback.
   */
  public function test(): void {
    $validator = new ServiceExists(
      new ServiceInfo(self::bootstrap()),
    );
    self::assertSame('entity_type.manager', $validator('entity_type.manager'));
    self::expectExceptionObject(new \UnexpectedValueException('Service does not exists.'));
    $validator('none.existing');
  }

}
