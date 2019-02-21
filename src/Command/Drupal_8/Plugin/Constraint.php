<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:plugin:constraint command.
 */
class Constraint extends BaseGenerator {

  protected $name = 'd8:plugin:constraint';
  protected $description = 'Generates constraint plugin';
  protected $alias = 'constraint';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::moduleQuestions() + Utils::pluginQuestions();

    $default_plugin_id = function (array $vars) {
      // Unlike other plugin types. Constraint IDs use camel case.
      return Utils::camelize($vars['name'] . $vars['plugin_label']);
    };
    $questions['plugin_id'] = new Question('Constraint ID', $default_plugin_id);
    $plugin_id_validator = function ($value) {
      if (!preg_match('/^[a-z][a-z0-9_]*[a-z0-9]$/i', $value)) {
        throw new \UnexpectedValueException('The value is not correct machine name.');
      }
      return $value;
    };
    $questions['plugin_id']->setValidator($plugin_id_validator);

    $default_class = function ($vars) {
      $unprefixed_plugin_id = preg_replace('/^' . Utils::camelize($vars['machine_name']) . '/', '', $vars['plugin_id']);
      return Utils::camelize($unprefixed_plugin_id) . 'Constraint';
    };
    $questions['class'] = new Question('Plugin class', $default_class);

    $input_types = [
      'entity' => 'Entity',
      'item_list' => 'Item list',
      'item' => 'Item',
      'raw_value' => 'Raw value',
    ];
    $type_choices = Utils::prepareChoices($input_types);
    $questions['input_type'] = new ChoiceQuestion('Type of data to validate', $type_choices, 'Item list');

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['input_type'] = array_search($vars['input_type'], $input_types);

    $this->addFile()
      ->path('src/Plugin/Validation/Constraint/{class}.php')
      ->template('d8/plugin/constraint.twig');

    $this->addFile()
      ->path('src/Plugin/Validation/Constraint/{class}Validator.php')
      ->template('d8/plugin/constraint-validator.twig');
  }

}
