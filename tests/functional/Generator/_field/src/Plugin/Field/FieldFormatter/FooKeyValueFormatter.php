<?php declare(strict_types = 1);

namespace Drupal\example\Plugin\Field\FieldFormatter;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\example\Plugin\Field\FieldType\FooItem;

/**
 * Plugin implementation of the 'example_foo_key_value' formatter.
 *
 * @FieldFormatter(
 *   id = "example_foo_key_value",
 *   label = @Translation("Key-value"),
 *   field_types = {"example_foo"},
 * )
 */
final class FooKeyValueFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {

    $element = [];

    foreach ($items as $delta => $item) {
      $table = [
        '#type' => 'table',
      ];

      // Value 1.
      if ($item->value_1) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 1'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->value_1 ? $this->t('Yes') : $this->t('No'),
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 2.
      if ($item->value_2) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 2'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->value_2 ? $this->t('Yes') : $this->t('No'),
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 3.
      if ($item->value_3) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 3'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->value_3,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 4.
      if ($item->value_4) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 4'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->value_4,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 5.
      if ($item->value_5) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 5'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->value_5,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 6.
      if ($item->value_6) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 6'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->value_6,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 7.
      if ($item->value_7) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 7'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->value_7,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 8.
      if ($item->value_8) {
        $allowed_values = FooItem::allowedValue8Values();

        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 8'),
              ],
            ],
            [
              'data' => [
                '#markup' => $allowed_values[$item->value_8],
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 9.
      if ($item->value_9) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 9'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->value_9,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 10.
      if ($item->value_10) {
        $allowed_values = FooItem::allowedValue10Values();

        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 10'),
              ],
            ],
            [
              'data' => [
                '#markup' => $allowed_values[$item->value_10],
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 11.
      if ($item->value_11) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 11'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->value_11,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 12.
      if ($item->value_12) {
        $allowed_values = FooItem::allowedValue12Values();

        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 12'),
              ],
            ],
            [
              'data' => [
                '#markup' => $allowed_values[$item->value_12],
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 13.
      if ($item->value_13) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 13'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->value_13,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 14.
      if ($item->value_14) {
        $allowed_values = FooItem::allowedValue14Values();

        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 14'),
              ],
            ],
            [
              'data' => [
                '#markup' => $allowed_values[$item->value_14],
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 15.
      if ($item->value_15) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 15'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->value_15,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 16.
      if ($item->value_16) {
        $allowed_values = FooItem::allowedValue16Values();

        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 16'),
              ],
            ],
            [
              'data' => [
                '#markup' => $allowed_values[$item->value_16],
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 17.
      if ($item->value_17) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 17'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->value_17,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 18.
      if ($item->value_18) {
        $allowed_values = FooItem::allowedValue18Values();

        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 18'),
              ],
            ],
            [
              'data' => [
                '#markup' => $allowed_values[$item->value_18],
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 19.
      if ($item->value_19) {
        $date = DrupalDateTime::createFromFormat('Y-m-d', $item->value_19);
        $date_formatter = \Drupal::service('date.formatter');
        $timestamp = $date->getTimestamp();
        $formatted_date = $date_formatter->format($timestamp, 'long');
        $iso_date = $date_formatter->format($timestamp, 'custom', 'Y-m-d\TH:i:s') . 'Z';

        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 19'),
              ],
            ],
            [
              'data' => [
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
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 20.
      if ($item->value_20) {
        $date = DrupalDateTime::createFromFormat('Y-m-d', $item->value_20);
        $date_formatter = \Drupal::service('date.formatter');
        $timestamp = $date->getTimestamp();
        $allowed_values = FooItem::allowedValue20Values();
        $formatted_date = $allowed_values[$item->value_20];
        $iso_date = $date_formatter->format($timestamp, 'custom', 'Y-m-d\TH:i:s') . 'Z';

        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Value 20'),
              ],
            ],
            [
              'data' => [
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
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      $element[$delta] = $table;
    }

    return $element;
  }

}
