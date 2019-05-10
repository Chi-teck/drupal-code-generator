<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Utils;

/**
 * Implements d8:plugin:constraint command.
 */
class Constraint extends PluginGenerator {

  protected $name = 'd8:plugin:constraint';
  protected $description = 'Generates constraint plugin';
  protected $alias = 'constraint';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $input_types = [
      'entity' => 'Entity',
      'item_list' => 'Item list',
      'item' => 'Item',
      'raw_value' => 'Raw value',
    ];
    $vars['input_type'] = $this->choice('Type of data to validate', $input_types, 'Item list');

    $this->addFile('src/Plugin/Validation/Constraint/{class}.php')
      ->template('d8/plugin/constraint');

    $this->addFile('src/Plugin/Validation/Constraint/{class}Validator.php')
      ->template('d8/plugin/constraint-validator');
  }

  /**
   * {@inheritdoc}
   */
  protected function askPluginIdQuestion(): string {
    // Unlike other plugin types. Constraint IDs use camel case.
    $default_plugin_id = '{name|camelize}{plugin_label|camelize}';
    $plugin_id_validator = function ($value) {
      if (!preg_match('/^[a-z][a-z0-9_]*[a-z0-9]$/i', $value)) {
        throw new \UnexpectedValueException('The value is not correct constraint ID.');
      }
      return $value;
    };
    return $this->ask('Constraint ID', $default_plugin_id, $plugin_id_validator);
  }

  /**
   * {@inheritdoc}
   */
  protected function askPluginClassQuestion(): string {
    $unprefixed_plugin_id = preg_replace('/^' . Utils::camelize($this->vars['machine_name']) . '/', '', $this->vars['plugin_id']);
    $default_class = Utils::camelize($unprefixed_plugin_id) . 'Constraint';
    return $this->ask('Plugin class', $default_class);
  }

}
