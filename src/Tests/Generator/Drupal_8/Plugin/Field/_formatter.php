<?php

namespace Drupal\foo\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'Zoo' formatter.
 *
 * @FieldFormatter(
 *   id = "foo_zoo",
 *   label = @Translation("Zoo"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class ZooFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'prefix' => '',
      'suffix' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $settings = $this->getSettings();

    $elements['prefix'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Prefix'),
      '#default_value' => $settings['prefix'],
    ];

    $elements['suffix'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Suffix'),
      '#default_value' => $settings['suffix'],
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settings = $this->getSettings();
    $summary = [];

    if ($settings['prefix']) {
      $summary[] = $this->t('Prefix: @prefix', ['@prefix' => $settings['prefix']]);
    }
    if ($settings['suffix']) {
      $summary[] = $this->t('Suffix: @suffix', ['@suffix' => $settings['suffix']]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $settings = $this->getSettings();

    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#type' => 'item',
        '#markup' => $item->value,
        '#field_prefix' => $settings['prefix'],
        '#field_suffix' => $settings['suffix'],
      ];
    }

    return $element;
  }

}
