<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

/**
 * Implements d8:plugin:action command.
 */
class Action extends PluginGenerator {

  protected $name = 'd8:plugin:action';
  protected $description = 'Generates action plugin';
  protected $alias = 'action';
  protected $pluginLabelQuestion = 'Action label';
  protected $pluginLabelDefault = 'Update node title';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['category'] = $this->ask('Action category', 'Custom');
    $vars['configurable'] = $this->confirm('Make the action configurable?', FALSE);

    $this->addFile('src/Plugin/Action/{class}.php', 'd8/plugin/action');

    if ($vars['configurable']) {
      $this->addSchemaFile()->template('d8/plugin/action-schema');
    }
  }

}
