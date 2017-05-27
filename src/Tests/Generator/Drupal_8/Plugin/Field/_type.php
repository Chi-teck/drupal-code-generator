<?php

namespace Drupal\example\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Component\Utility\Random;

/**
 * Defines the 'foo' field type.
 *
 * @FieldType(
 *   id = "foo",
 *   label = @Translation("Foo"),
 *   category = @Translation("General"),
 *   default_widget = "string_textfield",
 *   default_formatter = "string"
 * )
 *
 * @DSG: {
 * If you are implementing a single value field type you may want to inherit
 * this class form some of the base field item classes provided by Drupal core.
 *
 * @see Drupal\Core\Field\Plugin\Field\FieldType\NumericItemBase.
 * @see Drupal\Core\Field\Plugin\Field\FieldType
 *
 * @DCG: }
 */
class FooItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   *
   * @DSG: Optional.
   */
  public static function defaultStorageSettings() {
    $settings = ['lorem' => 123];
    return $settings + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   *
   * @DSG: Optional.
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $settings = $this->getSettings();

    $element['lorem'] = [
      '#type' => 'number',
      '#title' => t('Lorem'),
      // @DCG: For single setting you can use $this->getSetting('lorem');
      '#default_value' => $settings['lorem'],
      '#disabled' => $has_data,
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   *
   * @DSG: Optional.
   */
  public static function defaultFieldSettings() {
    $settings = ['ipsum' => 'Bla bla bla'];
    return $settings + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   *
   * @DSG: Optional.
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $settings = $this->getSettings();

    $element['ipsum'] = [
      '#type' => 'textfield',
      '#title' => t('Ipsum'),
      '#default_value' => $settings['ipsum'],
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   *
   * @DSG: Optional.
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

    // @DCG: See \Drupal\Core\TypedData\Plugin\DataType\* for possible types.
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Text value'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   *
   * @DSG: Optional.
   */
  public function getConstraints() {
    $constraints = parent::getConstraints();

    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();

    // @DCG: Assume our value should not be longer than 50 characters.
    $options['value']['Length']['max'] = 50;

    // @DSG: See \Drupal\Core\Validation\Plugin\Validation\Constraint\* for
    // @DCG: available constraints.
    $constraints[] = $constraint_manager->create('ComplexData', $options);
    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {

    $columns = [
      'value' => [
        'type' => 'varchar',
        'not null' => FALSE,
        'description' => '@TODO: Create a description for the column.',
        'length' => 255,
      ]
    ];

    $schema = [
      'columns' => $columns
      // @DCG: Add indexes here if needed.
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    $random = new Random();
    $values['value'] = $random->word(mt_rand(1, 50));
    return $values;
  }

}
