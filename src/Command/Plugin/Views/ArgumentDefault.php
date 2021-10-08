<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin\Views;

use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:views:argument-default command.
 */
final class ArgumentDefault extends PluginGenerator {

  protected $name = 'plugin:views:argument-default';
  protected $description = 'Generates views default argument plugin';
  protected $alias = 'views-argument-default';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['configurable'] = $this->confirm('Make the plugin configurable?', FALSE);

    $this->collectServices($vars, FALSE);

    $this->addFile('src/Plugin/views/argument_default/{class}.php')
      ->template('argument-default');

    if ($vars['configurable']) {
      $this->addSchemaFile('config/schema/{machine_name}.views.schema.yml')
        ->template('argument-default-schema');
    }
  }

}
