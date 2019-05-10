<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

/**
 * Implements d8:plugin:block command.
 */
class Block extends PluginGenerator {

  protected $name = 'd8:plugin:block';
  protected $description = 'Generates block plugin';
  protected $alias = 'block';
  protected $pluginClassSuffix = 'Block';
  protected $pluginLabelQuestion = 'Block admin label';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['category'] = $this->ask('Block category', 'Custom');
    $vars['configurable'] = $this->confirm('Make the block configurable?', FALSE);

    if ($this->confirm('Would you like to inject dependencies?', FALSE)) {
      $this->collectServices();
    }

    $vars['access'] = $this->confirm('Create access callback?', FALSE);

    $this->addFile('src/Plugin/Block/{class}.php', 'd8/plugin/block');

    if ($vars['configurable']) {
      $this->addFile('config/schema/{machine_name}.schema.yml')
        ->template('d8/plugin/block-schema')
        ->action('append');
    }
  }

}
