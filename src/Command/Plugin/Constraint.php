<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Utils;

/**
 * Implements plugin:constraint command.
 */
final class Constraint extends PluginGenerator {

  protected string $name = 'plugin:constraint';
  protected string $description = 'Generates constraint plugin';
  protected string $alias = 'constraint';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/constraint';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $input_types = [
      'entity' => 'Entity',
      'item_list' => 'Item list',
      'item' => 'Item',
      'raw_value' => 'Raw value',
    ];
    $vars['input_type'] = $this->choice('Type of data to validate', $input_types, 'Item list');

    $this->addFile('src/Plugin/Validation/Constraint/{class}.php')
      ->template('constraint');

    $this->addFile('src/Plugin/Validation/Constraint/{class}Validator.php')
      ->template('validator');
  }

  /**
   * {@inheritdoc}
   */
  protected function askPluginIdQuestion(): string {
    // Unlike other plugin types. Constraint IDs use camel case.
    $default_plugin_id = '{name|camelize}{plugin_label|camelize}';
    $plugin_id_validator = static function ($value) {
      if (!\preg_match('/^[a-z][a-z0-9_]*[a-z0-9]$/i', $value)) {
        throw new \UnexpectedValueException('The value is not correct constraint ID.');
      }
      return $value;
    };
    return $this->ask('Constraint ID', $default_plugin_id, $plugin_id_validator);
  }

  /**
   * {@inheritdoc}
   */
  protected function askPluginClassQuestion(array $vars): string {
    $unprefixed_plugin_id = \preg_replace('/^' . Utils::camelize($vars['machine_name']) . '/', '', $vars['plugin_id']);
    $default_class = Utils::camelize($unprefixed_plugin_id) . 'Constraint';
    return $this->ask('Plugin class', $default_class);
  }

}
