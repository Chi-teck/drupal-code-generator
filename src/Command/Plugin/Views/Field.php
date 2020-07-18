<?php

namespace DrupalCodeGenerator\Command\Plugin\Views;

use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:views:field command.
 */
final class Field extends PluginGenerator {

  protected $name = 'plugin:views:field';
  protected $description = 'Generates views field plugin';
  protected $alias = 'views-field';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['configurable'] = $this->confirm('Make the plugin configurable?', FALSE);

    $this->collectServices($vars, FALSE);

    $this->addFile('src/Plugin/views/field/{class}.php', 'field');

    if ($vars['configurable']) {
      $this->addSchemaFile('config/schema/{machine_name}.views.schema.yml')
        ->template('schema');
    }

  }

}
