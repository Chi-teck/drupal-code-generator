<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Command\Drupal_8\Plugin\PluginGenerator;

/**
 * Implements d8:plugin:views:field command.
 */
class Field extends PluginGenerator {

  protected $name = 'd8:plugin:views:field';
  protected $description = 'Generates views field plugin';
  protected $alias = 'views-field';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['configurable'] = $this->confirm('Make the plugin configurable?', FALSE);

    $this->collectServices(FALSE);

    $this->addFile('src/Plugin/views/field/{class}.php', 'd8/plugin/views/field');

    if ($vars['configurable']) {
      $this->addSchemaFile('config/schema/{machine_name}.views.schema.yml')
        ->template('d8/plugin/views/field-schema');
    }

  }

}
