<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Command\PluginGenerator;

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

    if ($this->confirm('Would you like to inject dependencies?', FALSE)) {
      $this->collectServices();
    }

    $this->addFile('src/Plugin/views/field/{class}.php')
      ->template('d8/plugin/views/field.twig');

    if ($vars['configurable']) {
      $this->addFile('config/schema/{machine_name}.views.schema.yml')
        ->template('d8/plugin/views/field-schema.twig')
        ->action('append');
    }

  }

}
