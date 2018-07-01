<?php

namespace Drupal\example\Plugin\Field\FieldFormatter;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Plugin implementation of the 'example_foo' formatter.
 *
 * @FieldFormatter(
 *   id = "example_foo",
 *   label = @Translation("Example"),
 *   field_types = {"example_foo"}
 * )
 */
class FooFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return ['foo' => 'bar'] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $settings = $this->getSettings();
    $element['foo'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Foo'),
      '#default_value' => $settings['foo'],
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settings = $this->getSettings();
    $summary[] = $this->t('Foo: @foo', ['@foo' => $settings['foo']]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {

      $element[$delta]['value_1'] = [
        '#type' => 'item',
        '#title' => $this->t('Value 1'),
        '#markup' => $item->value_1 ? $this->t('Yes') : $this->t('No'),
      ];

      $element[$delta]['value_2'] = [
        '#type' => 'item',
        '#title' => $this->t('Value 2'),
        '#markup' => $item->value_2 ? $this->t('Yes') : $this->t('No'),
      ];

      if ($item->value_3) {
        $element[$delta]['value_3'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 3'),
          '#markup' => $item->value_3,
        ];
      }

      if ($item->value_4) {
        $element[$delta]['value_4'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 4'),
          '#markup' => $item->value_4,
        ];
      }

      if ($item->value_5) {
        $element[$delta]['value_5'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 5'),
          '#markup' => $item->value_5,
        ];
      }

      if ($item->value_6) {
        $element[$delta]['value_6'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 6'),
          '#markup' => $item->value_6,
        ];
      }

      if ($item->value_7) {
        $element[$delta]['value_7'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 7'),
          '#markup' => $item->value_7,
        ];
      }

      if ($item->value_8) {
        $element[$delta]['value_8'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 8'),
          '#markup' => $item->value_8,
        ];
      }

      if ($item->value_9) {
        $element[$delta]['value_9'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 9'),
          '#markup' => $item->value_9,
        ];
      }

      if ($item->value_10) {
        $element[$delta]['value_10'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 10'),
          '#markup' => $item->value_10,
        ];
      }

      if ($item->value_11) {
        $element[$delta]['value_11'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 11'),
          '#markup' => $item->value_11,
        ];
      }

      if ($item->value_12) {
        $element[$delta]['value_12'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 12'),
          '#markup' => $item->value_12,
        ];
      }

      if ($item->value_13) {
        $url = Url::fromUri('mailto:' . $item->value_13);
        $element[$delta]['value_13'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 13'),
          '#markup' => Link::fromTextAndUrl($item->value_13, $url)->toString(),
        ];
      }

      if ($item->value_14) {
        $url = Url::fromUri('mailto:' . $item->value_14);
        $element[$delta]['value_14'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 14'),
          '#markup' => Link::fromTextAndUrl($item->value_14, $url)->toString(),
        ];
      }

      if ($item->value_15) {
        $url = Url::fromUri('tel:' . rawurlencode(preg_replace('/\s+/', '', $item->value_15)));
        $element[$delta]['value_15'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 15'),
          '#markup' => Link::fromTextAndUrl($item->value_15, $url)->toString(),
        ];
      }

      if ($item->value_16) {
        $url = Url::fromUri('tel:' . rawurlencode(preg_replace('/\s+/', '', $item->value_16)));
        $element[$delta]['value_16'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 16'),
          '#markup' => Link::fromTextAndUrl($item->value_16, $url)->toString(),
        ];
      }

      if ($item->value_17) {
        $url = Url::fromUri($item->value_17);
        $element[$delta]['value_17'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 17'),
          '#markup' => Link::fromTextAndUrl($item->value_17, $url)->toString(),
        ];
      }

      if ($item->value_18) {
        $url = Url::fromUri($item->value_18);
        $element[$delta]['value_18'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 18'),
          '#markup' => Link::fromTextAndUrl($item->value_18, $url)->toString(),
        ];
      }

      if ($item->value_19) {
        $date = DrupalDateTime::createFromFormat('Y-m-d', $item->value_19);
        $date_formatter = \Drupal::service('date.formatter');
        $timestamp = $date->getTimestamp();
        $formatted_date = $date_formatter->format($timestamp, 'long');
        $iso_date = $date_formatter->format($timestamp, 'custom', 'Y-m-d\TH:i:s') . 'Z';
        $element[$delta]['value_19'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 19'),
          'content' => [
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
        ];
      }

      if ($item->value_20) {
        $date = DrupalDateTime::createFromFormat('Y-m-d', $item->value_20);
        $date_formatter = \Drupal::service('date.formatter');
        $timestamp = $date->getTimestamp();
        $formatted_date = $date_formatter->format($timestamp, 'long');
        $iso_date = $date_formatter->format($timestamp, 'custom', 'Y-m-d\TH:i:s') . 'Z';
        $element[$delta]['value_20'] = [
          '#type' => 'item',
          '#title' => $this->t('Value 20'),
          'content' => [
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
        ];
      }

    }

    return $element;
  }

}
