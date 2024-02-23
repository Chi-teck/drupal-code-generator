<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;
use DrupalCodeGenerator\Validator\Required;
use DrupalCodeGenerator\Validator\RequiredMachineName;

#[Generator(
  name: 'field',
  description: 'Generates a field',
  templatePath: Application::TEMPLATE_PATH . '/_field',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Field extends BaseGenerator {

  /**
   * Field sub-types.
   */
  private const SUB_TYPES = [
    'boolean' => [
      'label' => 'Boolean',
      'list' => FALSE,
      'random' => FALSE,
      'inline' => FALSE,
      'link' => FALSE,
      'data_type' => 'boolean',
    ],
    'string' => [
      'label' => 'Text',
      'list' => TRUE,
      'random' => TRUE,
      'inline' => TRUE,
      'link' => FALSE,
      'data_type' => 'string',
    ],
    'text' => [
      'label' => 'Text (long)',
      'list' => FALSE,
      'random' => TRUE,
      'inline' => FALSE,
      'link' => FALSE,
      'data_type' => 'string',
    ],
    'integer' => [
      'label' => 'Integer',
      'list' => TRUE,
      'random' => FALSE,
      'inline' => TRUE,
      'link' => FALSE,
      'data_type' => 'integer',
    ],
    'float' => [
      'label' => 'Float',
      'list' => TRUE,
      'random' => FALSE,
      'inline' => TRUE,
      'link' => FALSE,
      'data_type' => 'float',
    ],
    'numeric' => [
      'label' => 'Numeric',
      'list' => TRUE,
      'random' => FALSE,
      'inline' => TRUE,
      'link' => FALSE,
      'data_type' => 'float',
    ],
    'email' => [
      'label' => 'Email',
      'list' => TRUE,
      'random' => TRUE,
      'inline' => TRUE,
      'link' => TRUE,
      'data_type' => 'email',
    ],
    'telephone' => [
      'label' => 'Telephone',
      'list' => TRUE,
      'random' => FALSE,
      'inline' => TRUE,
      'link' => TRUE,
      'data_type' => 'string',
    ],
    'uri' => [
      'label' => 'Url',
      'list' => TRUE,
      'random' => TRUE,
      'inline' => TRUE,
      'link' => TRUE,
      'data_type' => 'uri',
    ],
    'datetime' => [
      'label' => 'Date',
      'list' => TRUE,
      'random' => FALSE,
      'inline' => FALSE,
      'link' => FALSE,
      'data_type' => 'datetime_iso8601',
    ],
  ];

  /**
   * Date types.
   */
  private const DATE_TYPES = [
    'date' => 'Date only',
    'datetime' => 'Date and time',
  ];

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {

    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $vars['field_label'] = $ir->ask('Field label', 'Example', new Required());
    $vars['field_id'] = $ir->ask('Field ID', '{machine_name}_{field_label|h2m}', new RequiredMachineName());

    $subfield_count_validator = static function (mixed $value): int {
      if (!(\is_int($value) || \ctype_digit($value)) || (int) $value <= 0) {
        throw new \UnexpectedValueException('The value should be greater than zero.');
      }
      return (int) $value;
    };

    $vars['subfield_count'] = $ir->ask('How many sub-fields would you like to create?', '3', $subfield_count_validator);

    $type_choices = \array_combine(
      \array_keys(self::SUB_TYPES),
      \array_column(self::SUB_TYPES, 'label'),
    );

    // Indicates that at least one of sub-fields needs Random component.
    $vars['random'] = FALSE;

    // Indicates that all sub-fields can be rendered inline.
    $vars['inline'] = TRUE;

    // Indicates that at least one of sub-fields has limited allowed values.
    $vars['list'] = FALSE;

    // Indicates that at least one of sub-fields is required.
    $vars['required'] = FALSE;

    // Indicates that at least one of sub-fields is of email type.
    $vars['email'] = FALSE;

    // Indicates that at least one of sub-fields can be rendered as a link.
    $vars['link'] = FALSE;

    // Indicates that at least one of sub-fields is of datetime type.
    $vars['datetime'] = FALSE;

    $vars['type_class'] = '{field_label|camelize}Item';
    $vars['widget_class'] = '{field_label|camelize}Widget';
    $vars['formatter_class'] = '{field_label|camelize}DefaultFormatter';

    for ($i = 1; $i <= $vars['subfield_count']; $i++) {
      $this->io()->writeln(\sprintf('<fg=green>%s</>', \str_repeat('–', 50)));

      $subfield = new \stdClass();

      $subfield->name = $ir->ask("Label for sub-field #$i", "Value $i");
      $subfield->machineName = $ir->ask(
        "Machine name for sub-field #$i",
        Utils::human2machine($subfield->name),
        new RequiredMachineName(),
      );
      /** @var string $type */
      $type = $ir->choice("Type of sub-field #$i", $type_choices, 'Text');

      $subfield->dateType = $type === 'datetime' ?
        $ir->choice("Date type for sub-field #$i", self::DATE_TYPES, 'Date only') : NULL;

      $definition = self::SUB_TYPES[$type];
      if ($definition['list']) {
        $subfield->list = $ir->confirm("Limit allowed values for sub-field #$i?", FALSE);
      }
      $subfield->required = $ir->confirm("Make sub-field #$i required?", FALSE);

      // Build sub-field vars.
      $vars['subfields'][$i] = [
        'name' => $subfield->name,
        'machine_name' => $subfield->machineName,
        'type' => $type,
        'data_type' => $definition['data_type'],
        'list' => $subfield->list ?? FALSE,
        'allowed_values_method' => 'allowed' . Utils::camelize($subfield->name, TRUE) . 'Values',
        'required' => $subfield->required,
        'link' => $definition['link'],
      ];
      if ($subfield->dateType) {
        $vars['subfields'][$i]['date_type'] = $subfield->dateType;
        // Back to date type ID.
        $vars['subfields'][$i]['date_storage_format'] = $subfield->dateType === 'date' ? 'Y-m-d' : 'Y-m-d\TH:i:s';
      }

      if ($definition['random']) {
        $vars['random'] = TRUE;
      }

      if (!$definition['inline']) {
        $vars['inline'] = FALSE;
      }

      if ($vars['subfields'][$i]['list']) {
        $vars['list'] = TRUE;
      }

      if ($vars['subfields'][$i]['required']) {
        $vars['required'] = TRUE;
      }

      if ($type === 'email') {
        $vars['email'] = TRUE;
      }

      if ($definition['link']) {
        $vars['link'] = TRUE;
      }

      if ($type === 'datetime') {
        $vars['datetime'] = TRUE;
      }

    }

    $this->io()->writeln(\sprintf('<fg=green>%s</>', \str_repeat('–', 50)));

    $vars['storage_settings'] = $ir->confirm('Would you like to create field storage settings form?', FALSE);
    $vars['instance_settings'] = $ir->confirm('Would you like to create field instance settings form?', FALSE);
    $vars['widget_settings'] = $ir->confirm('Would you like to create field widget settings form?', FALSE);
    $vars['formatter_settings'] = $ir->confirm('Would you like to create field formatter settings form?', FALSE);
    $vars['table_formatter'] = $ir->confirm('Would you like to create table formatter?', FALSE);
    $vars['key_value_formatter'] = $ir->confirm('Would you like to create key-value formatter?', FALSE);

    $assets->addFile('src/Plugin/Field/FieldType/{type_class}.php', 'type.twig');

    $assets->addFile('src/Plugin/Field/FieldWidget/{widget_class}.php', 'widget.twig');

    $assets->addFile('src/Plugin/Field/FieldFormatter/{formatter_class}.php', 'default-formatter.twig');

    $assets->addSchemaFile()->template('schema.twig');

    $assets->addFile('{machine_name}.libraries.yml', 'libraries.twig')
      ->appendIfExists();

    $assets->addFile('css/{field_id|u2h}-widget.css', 'widget-css.twig');

    if ($vars['table_formatter']) {
      $vars['table_formatter_class'] = '{field_label|camelize}TableFormatter';
      $assets->addFile('src/Plugin/Field/FieldFormatter/{table_formatter_class}.php', '/table-formatter.twig');
    }

    if ($vars['key_value_formatter']) {
      $vars['key_value_formatter_class'] = '{field_label|camelize}KeyValueFormatter';
      $assets->addFile('src/Plugin/Field/FieldFormatter/{key_value_formatter_class}.php', 'key-value-formatter.twig');
    }

  }

}
