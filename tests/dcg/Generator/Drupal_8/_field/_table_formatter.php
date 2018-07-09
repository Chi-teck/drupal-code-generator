<?php

namespace Drupal\example\Plugin\Field\FieldFormatter;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\example\Plugin\Field\FieldType\FooItem;

/**
 * Plugin implementation of the 'example_foo' formatter.
 *
 * @FieldFormatter(
 *   id = "example_foo_table",
 *   label = @Translation("Table"),
 *   field_types = {"example_foo"}
 * )
 */
class FooTableFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $header[] = '#';
    $header[] = $this->t('Value 1');
    $header[] = $this->t('Value 2');
    $header[] = $this->t('Value 3');
    $header[] = $this->t('Value 4');
    $header[] = $this->t('Value 5');
    $header[] = $this->t('Value 6');
    $header[] = $this->t('Value 7');
    $header[] = $this->t('Value 8');
    $header[] = $this->t('Value 9');
    $header[] = $this->t('Value 10');
    $header[] = $this->t('Value 11');
    $header[] = $this->t('Value 12');
    $header[] = $this->t('Value 13');
    $header[] = $this->t('Value 14');
    $header[] = $this->t('Value 15');
    $header[] = $this->t('Value 16');
    $header[] = $this->t('Value 17');
    $header[] = $this->t('Value 18');
    $header[] = $this->t('Value 19');
    $header[] = $this->t('Value 20');

    $table = [
      '#type' => 'table',
      '#header' => $header,
    ];

    foreach ($items as $delta => $item) {
      $row = [];

      $row[]['#markup'] = $delta + 1;

      $row[]['#markup'] = $item->value_1 ? $this->t('Yes') : $this->t('No');

      $row[]['#markup'] = $item->value_2 ? $this->t('Yes') : $this->t('No');

      $row[]['#markup'] = $item->value_3;

      $row[]['#markup'] = $item->value_4;

      $row[]['#markup'] = $item->value_5;

      $row[]['#markup'] = $item->value_6;

      $row[]['#markup'] = $item->value_7;

      if ($item->value_8) {
        $allowed_values = FooItem::allowedValue8Values();
        $row[]['#markup'] = $allowed_values[$item->value_8];
      }
      else {
        $row[]['#markup'] = '';
      }

      $row[]['#markup'] = $item->value_9;

      if ($item->value_10) {
        $allowed_values = FooItem::allowedValue10Values();
        $row[]['#markup'] = $allowed_values[$item->value_10];
      }
      else {
        $row[]['#markup'] = '';
      }

      $row[]['#markup'] = $item->value_11;

      if ($item->value_12) {
        $allowed_values = FooItem::allowedValue12Values();
        $row[]['#markup'] = $allowed_values[$item->value_12];
      }
      else {
        $row[]['#markup'] = '';
      }

      $row[]['#markup'] = $item->value_13;

      if ($item->value_14) {
        $allowed_values = FooItem::allowedValue14Values();
        $row[]['#markup'] = $allowed_values[$item->value_14];
      }
      else {
        $row[]['#markup'] = '';
      }

      $row[]['#markup'] = $item->value_15;

      if ($item->value_16) {
        $allowed_values = FooItem::allowedValue16Values();
        $row[]['#markup'] = $allowed_values[$item->value_16];
      }
      else {
        $row[]['#markup'] = '';
      }

      $row[]['#markup'] = $item->value_17;

      if ($item->value_18) {
        $allowed_values = FooItem::allowedValue18Values();
        $row[]['#markup'] = $allowed_values[$item->value_18];
      }
      else {
        $row[]['#markup'] = '';
      }

      if ($item->value_19) {
        $date = DrupalDateTime::createFromFormat('Y-m-d', $item->value_19);
        $date_formatter = \Drupal::service('date.formatter');
        $timestamp = $date->getTimestamp();
        $formatted_date = $date_formatter->format($timestamp, 'long');
        $iso_date = $date_formatter->format($timestamp, 'custom', 'Y-m-d\TH:i:s') . 'Z';
        $row[] = [
          '#theme' => 'time',
          '#text' => $formatted_date,
          '#html' => FALSE,
          '#attributes' => [
            'datetime' => $iso_date,
          ],
          '#cache' => [
            'contexts' => [
              'timezone',
            ],
          ],
        ];
      }
      else {
        $row[]['#markup'] = '';
      }

      if ($item->value_20) {
        $date = DrupalDateTime::createFromFormat('Y-m-d', $item->value_20);
        $date_formatter = \Drupal::service('date.formatter');
        $timestamp = $date->getTimestamp();
        $allowed_values = FooItem::allowedValue20Values();
        $formatted_date = $allowed_values[$item->value_20];
        $iso_date = $date_formatter->format($timestamp, 'custom', 'Y-m-d\TH:i:s') . 'Z';
        $row[] = [
          '#theme' => 'time',
          '#text' => $formatted_date,
          '#html' => FALSE,
          '#attributes' => [
            'datetime' => $iso_date,
          ],
          '#cache' => [
            'contexts' => [
              'timezone',
            ],
          ],
        ];
      }
      else {
        $row[]['#markup'] = '';
      }

      $table[$delta] = $row;
    }

    return [$table];
  }

}
