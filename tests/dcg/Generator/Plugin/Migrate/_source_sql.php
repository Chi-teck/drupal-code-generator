<?php

namespace Drupal\example\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SourcePluginBase;
use Drupal\migrate\Row;

/**
 * The 'example_foo' source plugin.
 *
 * @MigrateSource(
 *   id = "example_foo",
 *   source_module = "example"
 * )
 */
class Foo extends SourcePluginBase {

  /**
   * {@inheritdoc}
   */
  public function __toString() {
    // @DCG You may return something meaningful here.
    return '';
  }

  /**
   * {@inheritdoc}
   */
  protected function initializeIterator() {

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
  public function fields() {
    return [
      'id' => $this->t('The record ID.'),
      'name' => $this->t('The record name.'),
      'status' => $this->t('The record status'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
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
  public function prepareRow(Row $row) {

    // @DCG
    // Extend/modify the row here if needed.
    //
    // Example:
    // @code
    // $name = $row->getSourceProperty('name');
    // $row->setSourceProperty('name', Html::escape('$name');
    // @endcode
    return parent::prepareRow($row);
  }

}
