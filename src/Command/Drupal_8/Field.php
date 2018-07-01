<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:field command.
 */
class Field extends BaseGenerator {

  protected $name = 'd8:field';
  protected $description = 'Generates a field';
  protected $alias = 'field';

  /**
   * All types.
   *
   * @var array
   */
  protected $allTypes = [
    'boolean' => 'Boolean',
    'string' => 'Text',
    'text' => 'Text (long)',
    'integer' => 'Integer',
    'float' => 'Float',
    'numeric' => 'Numeric',
    'email' => 'Email',
    'telephone' => 'Telephone',
    'uri' => 'Url',
    'datetime' => 'Date',
  ];

  /**
   * List types.
   *
   * @var array
   */
  protected $listTypes = [
    'string',
    'integer',
    'float',
    'numeric',
    'email',
    'telephone',
    'uri',
    'datetime',
  ];

  /**
   * Types that use Random component for generating sample values.
   *
   * @var array
   */
  protected $randomTypes = [
    'string',
    'text',
    'email',
    'uri',
  ];

  /**
   * Inline types.
   *
   * @var array
   */
  protected $inlineTypes = [
    'string',
    'integer',
    'float',
    'numeric',
    'email',
    'telephone',
    'uri',
    'datetime',
  ];

  /**
   * Links types.
   *
   * @var array
   */
  protected $linkTypes = [
    'email',
    'telephone',
    'uri',
  ];

  /**
   * Date types.
   *
   * @var array
   */
  protected $dateTypes = [
    'date' => 'Date only',
    'datetime' => 'Date and time',
  ];

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = Utils::defaultQuestions();

    $questions['field_label'] = new Question('Field label', 'Example');
    $questions['field_label']->setValidator([Utils::class, 'validateRequired']);

    $default_field_id = function (array $vars) {
      return $vars['machine_name'] . '_' . Utils::human2machine($vars['field_label']);
    };
    $questions['field_id'] = new Question('Field ID', $default_field_id);
    $questions['field_id']->setValidator([Utils::class, 'validateMachineName']);

    $questions['subfield_count'] = new Question('How many sub-fields would you like to create?', 3);

    $subfield_count_validator = function ($value) {
      if (!is_numeric($value) || intval($value) != $value || $value <= 0) {
        throw new \UnexpectedValueException('The value should be greater than zero.');
      }
      return $value;
    };
    $questions['subfield_count']->setValidator($subfield_count_validator);

    $vars = &$this->collectVars($input, $output, $questions);

    $type_choices = array_values($this->allTypes);

    // Make options start from 1 instead of 0.
    array_unshift($type_choices, NULL);
    unset($type_choices[0]);

    // Indicates that at least one of sub-fields needs Random component.
    $vars['random'] = FALSE;

    // Indicates that all sub-fields can be rendered inline.
    $vars['inline'] = TRUE;

    // Indicates that at least one of sub-files has limited allowed values.
    $vars['list'] = FALSE;

    // Indicates that at least one of sub-fields is required.
    $vars['required'] = FALSE;

    // Indicates that at least one of sub-fields is of email type.
    $vars['email'] = FALSE;

    // Indicates that at least one of sub-fields can be rendered as a link.
    $vars['link'] = FALSE;

    // Indicates that at least one of sub-fields is of datetime type.
    $vars['datetime'] = FALSE;

    for ($i = 1; $i <= $vars['subfield_count']; $i++) {

      $output->writeln('<fg=green>–––––––––––––––––––––––––––––––––––––––––––––––––––</>');
      $subfield_questions = [];
      $subfield_questions['name_' . $i] = new Question("Label for sub-field #$i", "Value $i");
      $default_machine_name = function (array $vars) use ($i) {
        return Utils::human2machine($vars['name_' . $i]);
      };
      $subfield_questions['machine_name_' . $i] = new Question("Machine name for sub-field #$i", $default_machine_name);
      $subfield_questions['type_' . $i] = new ChoiceQuestion("Type of sub-field #$i", $type_choices, 'Text');
      $this->collectVars($input, $output, $subfield_questions);

      // Reset previous questions since we already collected their answers.
      $subfield_questions = [];
      $type = array_search($vars['type_' . $i], $this->allTypes);

      if ($type == 'datetime') {
        $date_type_choices = array_values($this->dateTypes);
        // Make options start from 1 instead of 0.
        array_unshift($date_type_choices, NULL);
        unset($date_type_choices[0]);

        $subfield_questions['date_type_' . $i] = new ChoiceQuestion("Date type for sub-field #$i", $date_type_choices, 'Date only');
      }

      if (in_array($type, $this->listTypes)) {
        $subfield_questions['list_' . $i] = new ConfirmationQuestion("Limit allowed values for sub-field #$i?", FALSE);
      }
      $subfield_questions['required_' . $i] = new ConfirmationQuestion("Make sub-field #$i required?", FALSE);
      $this->collectVars($input, $output, $subfield_questions);

      $machine_name = $vars['machine_name_' . $i];

      switch ($type) {
        case 'text':
        case 'telephone':
          $data_type = 'string';
          break;

        case 'numeric':
          $data_type = 'float';
          break;

        case 'datetime':
          $data_type = 'datetime_iso8601';
          break;

        default:
          $data_type = $type;
      }

      // Group sub-field vars.
      $vars['subfields'][$i] = [
        'name' => $vars['name_' . $i],
        'machine_name' => $machine_name,
        'type' => $type,
        'data_type' => $data_type,
        'list' => !empty($vars['list_' . $i]),
        'required' => $vars['required_' . $i],
      ];
      if (isset($vars['date_type_' . $i])) {
        $date_type = array_search($vars['date_type_' . $i], $this->dateTypes);
        $vars['subfields'][$i]['date_type'] = $date_type;
        // Back to date type ID.
        $vars['subfields'][$i]['date_storage_format'] = $date_type == 'date' ? 'Y-m-d' : 'Y-m-d\TH:i:s';
      }
      unset($vars['name_' . $i], $vars['machine_name_' . $i], $vars['type_' . $i], $vars['list_' . $i], $vars['required_' . $i], $vars['date_type_' . $i]);

      if (in_array($type, $this->randomTypes)) {
        $vars['random'] = TRUE;
      }

      if (!in_array($type, $this->inlineTypes)) {
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

      if (in_array($type, $this->linkTypes)) {
        $vars['link'] = TRUE;
      }

      if ($type == 'datetime') {
        $vars['datetime'] = TRUE;
      }

      $property = "\$this->$machine_name";
      $vars['subfields'][$i]['is_empty_condition'] = $type == 'boolean'
        ? "$property == 1"
        : "$property !== NULL";
    }

    $output->writeln('<fg=green>–––––––––––––––––––––––––––––––––––––––––––––––––––</>');

    $settings_questions['storage_settings'] = new ConfirmationQuestion('Would you like to create field storage settings form?', FALSE);
    $settings_questions['instance_settings'] = new ConfirmationQuestion('Would you like to create field instance settings form?', FALSE);
    $settings_questions['widget_settings'] = new ConfirmationQuestion('Would you like to create field widget settings form?', FALSE);
    $settings_questions['formatter_settings'] = new ConfirmationQuestion('Would you like to create field formatter settings form?', FALSE);

    $vars += $this->collectVars($input, $output, $settings_questions);

    $vars['type_class'] = Utils::camelize($vars['field_label'] . 'Item');
    $vars['widget_class'] = Utils::camelize($vars['field_label'] . 'Widget');
    $vars['formatter_class'] = Utils::camelize($vars['field_label'] . 'Formatter');

    $this->addFile()
      ->path('src/Plugin/Field/FieldType/{type_class}.php')
      ->template('d8/_field/type.twig');

    $this->addFile()
      ->path('src/Plugin/Field/FieldWidget/{widget_class}.php')
      ->template('d8/_field/widget.twig');

    $this->addFile()
      ->path('src/Plugin/Field/FieldFormatter/{formatter_class}.php')
      ->template('d8/_field/formatter.twig');

    $this->addFile()
      ->path('config/schema/{machine_name}.schema.yml')
      ->template('d8/_field/schema.twig')
      ->action('append');

    $this->addFile()
      ->path('{machine_name}.libraries.yml')
      ->template('d8/_field/libraries.twig')
      ->action('append');

    $this->addFile()
      ->path('css/' . str_replace('_', '-', $vars['field_id']) . '-widget.css')
      ->template('d8/_field/widget-css.twig');
  }

}
