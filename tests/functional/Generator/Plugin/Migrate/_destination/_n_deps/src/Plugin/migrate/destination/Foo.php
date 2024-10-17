<?php

declare(strict_types=1);

namespace Drupal\example\Plugin\migrate\destination;

use Drupal\migrate\Attribute\MigrateDestination;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\Plugin\migrate\destination\DestinationBase;
use Drupal\migrate\Row;

/**
 * The 'example_foo' destination plugin.
 */
#[MigrateDestination('example_foo')]
final class Foo extends DestinationBase {

  /**
   * {@inheritdoc}
   */
  public function getIds(): array {
    $ids['id']['type'] = [
      'type' => 'integer',
      'unsigned' => TRUE,
      'size' => 'big',
    ];
    return $ids;
  }

  /**
   * {@inheritdoc}
   */
  public function fields(MigrationInterface $migration = NULL): array {
    return [
      'id' => $this->t('The row ID.'),
      // @todo Describe row fields here.
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function import(Row $row, array $old_destination_id_values = []): array|bool {
    // @todo Import the row here.
    return [$row->getDestinationProperty('id')];
  }

  /**
   * {@inheritdoc}
   */
  public function rollback(array $destination_identifier): void {
    // @todo Rollback the row here.
  }

}
