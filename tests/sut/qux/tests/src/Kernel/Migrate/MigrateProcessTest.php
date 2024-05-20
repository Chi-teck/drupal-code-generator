<?php

declare(strict_types=1);

namespace Drupal\Tests\qux\Kernel\Migrate;

use Drupal\KernelTests\KernelTestBase;
use Drupal\migrate\MigrateExecutable;
use Drupal\migrate\Row;
use PHPUnit\Framework\Attributes\Group;

/**
 * Test for MigrateProcess plugin.
 */
#[Group('DCG')]
final class MigrateProcessTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['migrate', 'qux'];

  /**
   * Test callback.
   */
  public function testBlockRendering(): void {
    $migrate_executable = $this->getMockBuilder(MigrateExecutable::class)
      ->disableOriginalConstructor()
      ->getMock();

    $row = new Row(['example']);
    $result = $this->container->get('plugin.manager.migrate.process')
      ->createInstance('example')
      ->transform('example', $migrate_executable, $row, NULL);

    self::assertSame('example', $result);
  }

}
