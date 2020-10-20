<?php

namespace Drupal\Tests\qux\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Test for MigrateProcess plugin.
 *
 * @group DCG
 */
final class MigrateProcessTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['migrate', 'qux'];

  /**
   * Test callback.
   */
  public function testBlockRendering(): void {

    $row = $this->getMockBuilder('Drupal\migrate\Row')
      ->getMock();

    $migrate_executable = $this->getMockBuilder('Drupal\migrate\MigrateExecutable')
      ->disableOriginalConstructor()
      ->getMock();

    $result = \Drupal::service('plugin.manager.migrate.process')
      ->createInstance('example')
      ->transform('бумеранг', $migrate_executable, $row, NULL);

    self::assertEquals('bumerang', $result);
  }

}
