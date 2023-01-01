<?php declare(strict_types = 1);

namespace Drupal\Tests\qux\Kernel\Migrate;

use Drupal\KernelTests\KernelTestBase;
use Drupal\migrate\Plugin\Migration;
use Drupal\migrate\Row;

/**
 * A test for migrate destination plugin.
 *
 * @group DCG
 */
final class DestinationTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['migrate', 'qux'];

  /**
   * Test callback.
   */
  public function testDestination(): void {

    $migration = $this->getMockBuilder(Migration::class)
      ->disableOriginalConstructor()
      ->getMock();

    $plugin = $this->container->get('plugin.manager.migrate.destination')
      ->createInstance('example', migration: $migration);

    $expected_ids['id']['type'] = [
      'type' => 'integer',
      'unsigned' => TRUE,
      'size' => 'big',
    ];
    self::assertSame($expected_ids, $plugin->getIds());

    $expected_fields = ['id' => 'The row ID.'];
    self::assertEquals($expected_fields, $plugin->fields());

    $row = new Row();
    $row->setDestinationProperty('id', 123);
    self::assertSame([123], $plugin->import($row));

    $plugin->rollback([]);
  }

}
