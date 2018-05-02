<?php

namespace Drupal\Tests\qux\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Test for MigrateProcess plugin.
 *
 * @group DCG
 */
class MigrateProcessTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['migrate', 'qux'];

  /**
   * Test callback.
   */
  public function testBlockRendering() {

    $row = $this->getMockBuilder('Drupal\migrate\Row')
      ->getMock();

    $migrate_executable = $this->getMockBuilder('Drupal\migrate\MigrateExecutable')
      ->disableOriginalConstructor()
      ->getMock();

    $result = \Drupal::service('plugin.manager.migrate.process')
      ->createInstance('example')
      ->transform('бумеранг', $migrate_executable, $row, NULL);

    $this->assertEquals('bumerang', $result);
  }

}
