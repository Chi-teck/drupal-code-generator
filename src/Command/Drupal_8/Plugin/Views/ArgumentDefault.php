<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Command\Drupal_8\Plugin\PluginGenerator;

/**
 * Implements d8:plugin:views:argument-default command.
 */
class ArgumentDefault extends PluginGenerator {

  protected $name = 'd8:plugin:views:argument-default';
  protected $description = 'Generates views default argument plugin';
  protected $alias = 'views-argument-default';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['configurable'] = $this->confirm('Make the plugin configurable?', FALSE);

    $this->collectServices(FALSE);

    $this->addFile('src/Plugin/views/argument_default/{class}.php')
      ->template('d8/plugin/views/argument-default');

    if ($vars['configurable']) {
      $this->addSchemaFile('config/schema/{machine_name}.views.schema.yml')
        ->template('d8/plugin/views/argument-default-schema');
    }
  }

}
