<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Utils;

/**
 * Implements field command.
 */
final class Field extends ModuleGenerator {

  protected string $name = 'field';
  protected string $description = 'Generates a field';
  protected string $templatePath = Application::TEMPLATE_PATH . '/field';

  /**
   * Field sub-types.
   *
   * @var array
   */
  private array $subTypes = [
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
   *
   * @var array
   */
  protected array $dateTypes = [
    'date' => 'Date only',
    'datetime' => 'Date and time',
  ];

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {

    $this->collectDefault($vars);

    $vars['field_label'] = $this->ask('Field label', 'Example', '::validateRequired');
    $vars['field_id'] = $this->ask('Field ID', '{machine_name}_{field_label|h2m}', '::validateRequiredMachineName');

    $subfield_count_validator = static function ($value) {
      if (!\is_numeric($value) || \intval($value) != $value || $value <= 0) {
        throw new \UnexpectedValueException('The value should be greater than zero.');
      }
      return $value;
    };

    $vars['subfield_count'] = $this->ask('How many sub-fields would you like to create?', '3', $subfield_count_validator);

    $type_choice_keys = \array_keys($this->subTypes);
    $type_choice_labels = \array_column($this->subTypes, 'label');
    $type_choices = \array_combine($type_choice_keys, $type_choice_labels);

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
      $this->io->writeln(\sprintf('<fg=green>%s</>', \str_repeat('–', 50)));

      $subfield = new \stdClass();

      $subfield->name = $this->ask("Label for sub-field #$i", "Value $i");
      $subfield->machineName = $this->ask("Machine name for sub-field #$i", Utils::human2machine($subfield->name));
      $type = $this->choice("Type of sub-field #$i", $type_choices, 'Text');

      if ($type == 'datetime') {
        $subfield->dateType = $this->choice("Date type for sub-field #$i", $this->dateTypes, 'Date only');
      }

      $definition = $this->subTypes[$type];
      if ($definition['list']) {
        $subfield->list = $this->confirm("Limit allowed values for sub-field #$i?", FALSE);
      }
      $subfield->required = $this->confirm("Make sub-field #$i required?", FALSE);

      // Build sub-field vars.
      $vars['subfields'][$i] = [
        'name' => $subfield->name,
        'machine_name' => $subfield->machineName,
        'type' => $type,
        'data_type' => $definition['data_type'],
        'list' => !empty($subfield->list),
        'allowed_values_method' => 'allowed' . Utils::camelize($subfield->name, TRUE) . 'Values',
        'required' => $subfield->required,
        'link' => $definition['link'],
      ];
      if (isset($subfield->dateType)) {
        $vars['subfields'][$i]['date_type'] = $subfield->dateType;
        // Back to date type ID.
        $vars['subfields'][$i]['date_storage_format'] = $subfield->dateType == 'date' ? 'Y-m-d' : 'Y-m-d\TH:i:s';
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

      if ($type == 'email') {
        $vars['email'] = TRUE;
      }

      if ($definition['link']) {
        $vars['link'] = TRUE;
      }

      if ($type == 'datetime') {
        $vars['datetime'] = TRUE;
      }

    }

    $this->io->writeln(\sprintf('<fg=green>%s</>', \str_repeat('–', 50)));

    $vars['storage_settings'] = $this->confirm('Would you like to create field storage settings form?', FALSE);
    $vars['instance_settings'] = $this->confirm('Would you like to create field instance settings form?', FALSE);
    $vars['widget_settings'] = $this->confirm('Would you like to create field widget settings form?', FALSE);
    $vars['formatter_settings'] = $this->confirm('Would you like to create field formatter settings form?', FALSE);
    $vars['table_formatter'] = $this->confirm('Would you like to create table formatter?', FALSE);
    $vars['key_value_formatter'] = $this->confirm('Would you like to create key-value formatter?', FALSE);

    $this->addFile('src/Plugin/Field/FieldType/{type_class}.php', 'type');

    $this->addFile('src/Plugin/Field/FieldWidget/{widget_class}.php', 'widget');

    $this->addFile('src/Plugin/Field/FieldFormatter/{formatter_class}.php', 'default-formatter');

    $this->addSchemaFile()->template('schema');

    $this->addFile('{machine_name}.libraries.yml', 'libraries')
      ->appendIfExists();

    $this->addFile('css/{field_id|u2h}-widget.css', 'widget-css');

    if ($vars['table_formatter']) {
      $vars['table_formatter_class'] = '{field_label|camelize}TableFormatter';
      $this->addFile('src/Plugin/Field/FieldFormatter/{table_formatter_class}.php', '/table-formatter');
    }

    if ($vars['key_value_formatter']) {
      $vars['key_value_formatter_class'] = '{field_label|camelize}KeyValueFormatter';
      $this->addFile('src/Plugin/Field/FieldFormatter/{key_value_formatter_class}.php', 'key-value-formatter');
    }

  }

}
