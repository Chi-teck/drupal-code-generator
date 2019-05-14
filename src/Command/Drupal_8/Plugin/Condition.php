<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

/**
 * Implements d8:plugin:condition command.
 */
class Condition extends PluginGenerator {

  protected $name = 'd8:plugin:condition';
  protected $description = 'Generates condition plugin';
  protected $alias = 'condition';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('src/Plugin/Condition/{class}.php', 'd8/plugin/condition');
    $this->addSchemaFile()->template('d8/plugin/condition-schema');
  }

}
