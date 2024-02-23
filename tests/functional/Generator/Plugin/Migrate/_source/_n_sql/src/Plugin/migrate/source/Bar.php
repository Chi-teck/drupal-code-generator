<?php

declare(strict_types=1);

namespace Drupal\example\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SourcePluginBase;
use Drupal\migrate\Row;

/**
 * The 'example_bar' source plugin.
 *
 * @MigrateSource(
 *   id = "example_bar",
 *   source_module = "example",
 * )
 */
final class Bar extends SourcePluginBase {

  /**
   * {@inheritdoc}
   */
  public function __toString(): string {
    // @DCG You may return something meaningful here.
    return '';
  }

  /**
   * {@inheritdoc}
   */
  protected function initializeIterator(): \ArrayIterator {
    // @DCG
    // In this example we return a hardcoded set of records.
    //
    // For large sets of data consider using generators like follows:
    // @code
    // foreach ($foo->nextRecord() as $record) {
    //  yield $record;
    // }
    // @endcode
    $records = [
      [
        'id' => 1,
        'name' => 'Alpha',
        'status' => TRUE,
      ],
      [
        'id' => 2,
        'name' => 'Beta',
        'status' => FALSE,
      ],
      [
        'id' => 3,
        'name' => 'Gamma',
        'status' => TRUE,
      ],
    ];

    return new \ArrayIterator($records);
  }

  /**
   * {@inheritdoc}
   */
  public function fields(): array {
    return [
      'id' => $this->t('The record ID.'),
      'name' => $this->t('The record name.'),
      'status' => $this->t('The record status'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getIds(): array {
    $ids['id'] = [
      'type' => 'integer',
      'unsigned' => TRUE,
      'size' => 'big',
    ];
    return $ids;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row): bool {
    // @DCG
    // Modify the row here if needed.
    // Example:
    // @code
    //   $name = $row->getSourceProperty('name');
    //   $row->setSourceProperty('name', Html::escape('$name'));
    // @endcode
    return parent::prepareRow($row);
  }

}
