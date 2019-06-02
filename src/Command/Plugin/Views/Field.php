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
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['configurable'] = $this->confirm('Make the plugin configurable?', FALSE);

    $this->collectServices(FALSE);

    $this->addFile('src/Plugin/views/field/{class}.php', 'plugin/views/field');

    if ($vars['configurable']) {
      $this->addSchemaFile('config/schema/{machine_name}.views.schema.yml')
        ->template('plugin/views/field-schema');
    }

  }

}
