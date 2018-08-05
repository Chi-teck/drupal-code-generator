<?php

namespace Drupal\example\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\Email;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'example_foo' field type.
 *
 * @FieldType(
 *   id = "example_foo",
 *   label = @Translation("Foo"),
 *   category = @Translation("General"),
 *   default_widget = "example_foo",
 *   default_formatter = "example_foo_default"
 * )
 */
class FooItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    $settings = ['foo' => 'example'];
    return $settings + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $settings = $this->getSettings();

    $element['foo'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Foo'),
      '#default_value' => $settings['foo'],
      '#disabled' => $has_data,
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    $settings = ['bar' => 'example'];
    return $settings + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $settings = $this->getSettings();

    $element['bar'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Foo'),
      '#default_value' => $settings['bar'],
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    if ($this->value_1 == 1) {
      return FALSE;
    }
    elseif ($this->value_2 == 1) {
      return FALSE;
    }
    elseif ($this->value_3 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_4 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_5 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_6 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_7 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_8 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_9 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_10 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_11 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_12 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_13 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_14 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_15 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_16 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_17 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_18 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_19 !== NULL) {
      return FALSE;
    }
    elseif ($this->value_20 !== NULL) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

    $properties['value_1'] = DataDefinition::create('boolean')
      ->setLabel(t('Value 1'));
    $properties['value_2'] = DataDefinition::create('boolean')
      ->setLabel(t('Value 2'));
    $properties['value_3'] = DataDefinition::create('string')
      ->setLabel(t('Value 3'));
    $properties['value_4'] = DataDefinition::create('string')
      ->setLabel(t('Value 4'));
    $properties['value_5'] = DataDefinition::create('string')
      ->setLabel(t('Value 5'));
    $properties['value_6'] = DataDefinition::create('string')
      ->setLabel(t('Value 6'));
    $properties['value_7'] = DataDefinition::create('integer')
      ->setLabel(t('Value 7'));
    $properties['value_8'] = DataDefinition::create('integer')
      ->setLabel(t('Value 8'));
    $properties['value_9'] = DataDefinition::create('float')
      ->setLabel(t('Value 9'));
    $properties['value_10'] = DataDefinition::create('float')
      ->setLabel(t('Value 10'));
    $properties['value_11'] = DataDefinition::create('float')
      ->setLabel(t('Value 11'));
    $properties['value_12'] = DataDefinition::create('float')
      ->setLabel(t('Value 12'));
    $properties['value_13'] = DataDefinition::create('email')
      ->setLabel(t('Value 13'));
    $properties['value_14'] = DataDefinition::create('email')
      ->setLabel(t('Value 14'));
    $properties['value_15'] = DataDefinition::create('string')
      ->setLabel(t('Value 15'));
    $properties['value_16'] = DataDefinition::create('string')
      ->setLabel(t('Value 16'));
    $properties['value_17'] = DataDefinition::create('uri')
      ->setLabel(t('Value 17'));
    $properties['value_18'] = DataDefinition::create('uri')
      ->setLabel(t('Value 18'));
    $properties['value_19'] = DataDefinition::create('datetime_iso8601')
      ->setLabel(t('Value 19'));
    $properties['value_20'] = DataDefinition::create('datetime_iso8601')
      ->setLabel(t('Value 20'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraints = parent::getConstraints();

    // NotBlank validator is not suitable for booleans because it does not
    // recognize '0' as an empty value.
    $options['value_2']['AllowedValues']['choices'] = [1];
    $options['value_2']['AllowedValues']['message'] = $this->t('This value should not be blank.');

    $options['value_6']['NotBlank'] = [];

    $options['value_8']['AllowedValues'] = array_keys(FooItem::allowedValue8Values());

    $options['value_10']['AllowedValues'] = array_keys(FooItem::allowedValue10Values());

    $options['value_11']['NotBlank'] = [];

    $options['value_12']['AllowedValues'] = array_keys(FooItem::allowedValue12Values());

    $options['value_13']['NotBlank'] = [];

    $options['value_13']['Length']['max'] = Email::EMAIL_MAX_LENGTH;

    $options['value_14']['AllowedValues'] = array_keys(FooItem::allowedValue14Values());

    $options['value_14']['NotBlank'] = [];

    $options['value_14']['Length']['max'] = Email::EMAIL_MAX_LENGTH;

    $options['value_15']['NotBlank'] = [];

    $options['value_16']['AllowedValues'] = array_keys(FooItem::allowedValue16Values());

    $options['value_16']['NotBlank'] = [];

    $options['value_18']['AllowedValues'] = array_keys(FooItem::allowedValue18Values());

    $options['value_18']['NotBlank'] = [];

    $options['value_19']['NotBlank'] = [];

    $options['value_20']['AllowedValues'] = array_keys(FooItem::allowedValue20Values());

    $options['value_20']['NotBlank'] = [];

    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $constraints[] = $constraint_manager->create('ComplexData', $options);
    // @todo Add more constrains here.
    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {

    $columns = [
      'value_1' => [
        'type' => 'int',
        'size' => 'tiny',
      ],
      'value_2' => [
        'type' => 'int',
        'size' => 'tiny',
      ],
      'value_3' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'value_4' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'value_5' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'value_6' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'value_7' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'value_8' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'value_9' => [
        'type' => 'float',
        'size' => 'normal',
      ],
      'value_10' => [
        'type' => 'float',
        'size' => 'normal',
      ],
      'value_11' => [
        'type' => 'numeric',
        'precision' => 10,
        'scale' => 2,
      ],
      'value_12' => [
        'type' => 'numeric',
        'precision' => 10,
        'scale' => 2,
      ],
      'value_13' => [
        'type' => 'varchar',
        'length' => Email::EMAIL_MAX_LENGTH,
      ],
      'value_14' => [
        'type' => 'varchar',
        'length' => Email::EMAIL_MAX_LENGTH,
      ],
      'value_15' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'value_16' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'value_17' => [
        'type' => 'varchar',
        'length' => 2048,
      ],
      'value_18' => [
        'type' => 'varchar',
        'length' => 2048,
      ],
      'value_19' => [
        'type' => 'varchar',
        'length' => 20,
      ],
      'value_20' => [
        'type' => 'varchar',
        'length' => 20,
      ],
    ];

    $schema = [
      'columns' => $columns,
      // @DCG Add indexes here if necessary.
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {

    $random = new Random();

    $values['value_1'] = (bool) mt_rand(0, 1);

    $values['value_2'] = (bool) mt_rand(0, 1);

    $values['value_3'] = $random->word(mt_rand(1, 255));

    $values['value_4'] = $random->word(mt_rand(1, 255));

    $values['value_5'] = $random->paragraphs(5);

    $values['value_6'] = $random->paragraphs(5);

    $values['value_7'] = mt_rand(-1000, 1000);

    $values['value_8'] = array_rand(self::allowedValue8Values());

    $scale = rand(1, 5);
    $random_decimal =  mt_rand() / mt_getrandmax() * (1000 - 0);
    $values['value_9'] = floor($random_decimal * pow(10, $scale)) / pow(10, $scale);

    $values['value_10'] = array_rand(self::allowedValue10Values());

    $scale = rand(10, 2);
    $random_decimal = -1000 + mt_rand() / mt_getrandmax() * (-1000 - 1000);
    $values['value_11'] = floor($random_decimal * pow(10, $scale)) / pow(10, $scale);

    $values['value_12'] = array_rand(self::allowedValue12Values());

    $values['value_13'] = strtolower($random->name()) . '@example.com';

    $values['value_14'] = array_rand(self::allowedValue14Values());

    $values['value_15'] = mt_rand(pow(10, 8), pow(10, 9) - 1);

    $values['value_16'] = array_rand(self::allowedValue16Values());

    $tlds = ['com', 'net', 'gov', 'org', 'edu', 'biz', 'info'];
    $domain_length = mt_rand(7, 15);
    $protocol = mt_rand(0, 1) ? 'https' : 'http';
    $www = mt_rand(0, 1) ? 'www' : '';
    $domain = $random->word($domain_length);
    $tld = $tlds[mt_rand(0, (count($tlds) - 1))];
    $values['value_17'] = "$protocol://$www.$domain.$tld";

    $values['value_18'] = array_rand(self::allowedValue18Values());

    $timestamp = \Drupal::time()->getRequestTime() - mt_rand(0, 86400 * 365);
    $values['value_19'] = gmdate('Y-m-d', $timestamp);

    $values['value_20'] = array_rand(self::allowedValue20Values());

    return $values;
  }

  /**
   * Returns allowed values for 'value_8' sub-field.
   *
   * @return array
   *   The list of allowed values.
   */
  public static function allowedValue8Values() {
    return [
      123 => 123,
      456 => 456,
      789 => 789,
    ];
  }

  /**
   * Returns allowed values for 'value_10' sub-field.
   *
   * @return array
   *   The list of allowed values.
   */
  public static function allowedValue10Values() {
    return [
      '12.3' => '12.3',
      '4.56' => '4.56',
      '0.789' => '0.789',
    ];
  }

  /**
   * Returns allowed values for 'value_12' sub-field.
   *
   * @return array
   *   The list of allowed values.
   */
  public static function allowedValue12Values() {
    return [
      '12.30' => '12.30',
      '45.60' => '45.60',
      '78.90' => '78.90',
    ];
  }

  /**
   * Returns allowed values for 'value_14' sub-field.
   *
   * @return array
   *   The list of allowed values.
   */
  public static function allowedValue14Values() {
    return [
      'alpha@example.com' => 'alpha@example.com',
      'beta@example.com' => 'beta@example.com',
      'gamma@example.com' => 'gamma@example.com',
    ];
  }

  /**
   * Returns allowed values for 'value_16' sub-field.
   *
   * @return array
   *   The list of allowed values.
   */
  public static function allowedValue16Values() {
    return [
      '71234567001' => '+7(123)45-67-001',
      '71234567002' => '+7(123)45-67-002',
      '71234567003' => '+7(123)45-67-003',
    ];
  }

  /**
   * Returns allowed values for 'value_18' sub-field.
   *
   * @return array
   *   The list of allowed values.
   */
  public static function allowedValue18Values() {
    return [
      'https://example.com' => 'https://example.com',
      'http://www.php.net' => 'http://www.php.net',
      'https://www.drupal.org' => 'https://www.drupal.org',
    ];
  }

  /**
   * Returns allowed values for 'value_20' sub-field.
   *
   * @return array
   *   The list of allowed values.
   */
  public static function allowedValue20Values() {
    return [
      '2018-01-01' => '1 January 2018',
      '2018-02-01' => '1 February 2018',
      '2018-03-01' => '1 March 2018',
    ];
  }

}
