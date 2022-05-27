<?php

namespace Drupal\example\Plugin\Field\FieldWidget;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\example\Plugin\Field\FieldType\FooItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'example_foo' field widget.
 *
 * @FieldWidget(
 *   id = "example_foo",
 *   label = @Translation("Foo"),
 *   field_types = {"example_foo"},
 * )
 */
class FooWidget extends WidgetBase {

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
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $element['value_1'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Value 1'),
      '#default_value' => $items[$delta]->value_1 ?? NULL,
    ];

    $element['value_2'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Value 2'),
      '#default_value' => $items[$delta]->value_2 ?? NULL,
    ];

    $element['value_3'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Value 3'),
      '#default_value' => $items[$delta]->value_3 ?? NULL,
    ];

    $element['value_4'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Value 4'),
      '#default_value' => $items[$delta]->value_4 ?? NULL,
    ];

    $element['value_5'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Value 5'),
      '#default_value' => $items[$delta]->value_5 ?? NULL,
    ];

    $element['value_6'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Value 6'),
      '#default_value' => $items[$delta]->value_6 ?? NULL,
    ];

    $element['value_7'] = [
      '#type' => 'number',
      '#title' => $this->t('Value 7'),
      '#default_value' => $items[$delta]->value_7 ?? NULL,
    ];

    $element['value_8'] = [
      '#type' => 'select',
      '#title' => $this->t('Value 8'),
      '#options' => ['' => $this->t('- None -')] + FooItem::allowedValue8Values(),
      '#default_value' => $items[$delta]->value_8 ?? NULL,
    ];

    $element['value_9'] = [
      '#type' => 'number',
      '#title' => $this->t('Value 9'),
      '#default_value' => $items[$delta]->value_9 ?? NULL,
      '#step' => 0.001,
    ];

    $element['value_10'] = [
      '#type' => 'select',
      '#title' => $this->t('Value 10'),
      '#options' => ['' => $this->t('- None -')] + FooItem::allowedValue10Values(),
      '#default_value' => $items[$delta]->value_10 ?? NULL,
    ];

    $element['value_11'] = [
      '#type' => 'number',
      '#title' => $this->t('Value 11'),
      '#default_value' => $items[$delta]->value_11 ?? NULL,
      '#step' => 0.01,
    ];

    $element['value_12'] = [
      '#type' => 'select',
      '#title' => $this->t('Value 12'),
      '#options' => ['' => $this->t('- None -')] + FooItem::allowedValue12Values(),
      '#default_value' => $items[$delta]->value_12 ?? NULL,
    ];

    $element['value_13'] = [
      '#type' => 'email',
      '#title' => $this->t('Value 13'),
      '#default_value' => $items[$delta]->value_13 ?? NULL,
    ];

    $element['value_14'] = [
      '#type' => 'select',
      '#title' => $this->t('Value 14'),
      '#options' => ['' => $this->t('- Select a value -')] + FooItem::allowedValue14Values(),
      '#default_value' => $items[$delta]->value_14 ?? NULL,
    ];

    $element['value_15'] = [
      '#type' => 'tel',
      '#title' => $this->t('Value 15'),
      '#default_value' => $items[$delta]->value_15 ?? NULL,
    ];

    $element['value_16'] = [
      '#type' => 'select',
      '#title' => $this->t('Value 16'),
      '#options' => ['' => $this->t('- Select a value -')] + FooItem::allowedValue16Values(),
      '#default_value' => $items[$delta]->value_16 ?? NULL,
    ];

    $element['value_17'] = [
      '#type' => 'url',
      '#title' => $this->t('Value 17'),
      '#default_value' => $items[$delta]->value_17 ?? NULL,
    ];

    $element['value_18'] = [
      '#type' => 'select',
      '#title' => $this->t('Value 18'),
      '#options' => ['' => $this->t('- Select a value -')] + FooItem::allowedValue18Values(),
      '#default_value' => $items[$delta]->value_18 ?? NULL,
    ];

    $element['value_19'] = [
      '#type' => 'datetime',
      '#title' => $this->t('Value 19'),
      '#default_value' => NULL,
      '#date_time_element' => 'none',
      '#date_time_format' => '',
    ];
    if (isset($items[$delta]->value_19)) {
      $element['value_19']['#default_value'] = DrupalDateTime::createFromFormat(
        'Y-m-d',
        $items[$delta]->value_19,
        'UTC'
      );
    }

    $element['value_20'] = [
      '#type' => 'select',
      '#title' => $this->t('Value 20'),
      '#options' => ['' => $this->t('- Select a value -')] + FooItem::allowedValue20Values(),
      '#default_value' => $items[$delta]->value_20 ?? NULL,
    ];

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'example-foo-elements';
    $element['#attached']['library'][] = 'example/example_foo';

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function errorElement(array $element, ConstraintViolationInterface $violation, array $form, FormStateInterface $form_state) {
    return isset($violation->arrayPropertyPath[0]) ? $element[$violation->arrayPropertyPath[0]] : $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as $delta => $value) {
      if ($value['value_1'] === '') {
        $values[$delta]['value_1'] = NULL;
      }
      if ($value['value_2'] === '') {
        $values[$delta]['value_2'] = NULL;
      }
      if ($value['value_3'] === '') {
        $values[$delta]['value_3'] = NULL;
      }
      if ($value['value_4'] === '') {
        $values[$delta]['value_4'] = NULL;
      }
      if ($value['value_5'] === '') {
        $values[$delta]['value_5'] = NULL;
      }
      if ($value['value_6'] === '') {
        $values[$delta]['value_6'] = NULL;
      }
      if ($value['value_7'] === '') {
        $values[$delta]['value_7'] = NULL;
      }
      if ($value['value_8'] === '') {
        $values[$delta]['value_8'] = NULL;
      }
      if ($value['value_9'] === '') {
        $values[$delta]['value_9'] = NULL;
      }
      if ($value['value_10'] === '') {
        $values[$delta]['value_10'] = NULL;
      }
      if ($value['value_11'] === '') {
        $values[$delta]['value_11'] = NULL;
      }
      if ($value['value_12'] === '') {
        $values[$delta]['value_12'] = NULL;
      }
      if ($value['value_13'] === '') {
        $values[$delta]['value_13'] = NULL;
      }
      if ($value['value_14'] === '') {
        $values[$delta]['value_14'] = NULL;
      }
      if ($value['value_15'] === '') {
        $values[$delta]['value_15'] = NULL;
      }
      if ($value['value_16'] === '') {
        $values[$delta]['value_16'] = NULL;
      }
      if ($value['value_17'] === '') {
        $values[$delta]['value_17'] = NULL;
      }
      if ($value['value_18'] === '') {
        $values[$delta]['value_18'] = NULL;
      }
      if ($value['value_19'] === '') {
        $values[$delta]['value_19'] = NULL;
      }
      if ($value['value_19'] instanceof DrupalDateTime) {
        $values[$delta]['value_19'] = $value['value_19']->format('Y-m-d');
      }
      if ($value['value_20'] === '') {
        $values[$delta]['value_20'] = NULL;
      }
      if ($value['value_20'] instanceof DrupalDateTime) {
        $values[$delta]['value_20'] = $value['value_20']->format('Y-m-d');
      }
    }
    return $values;
  }

}
