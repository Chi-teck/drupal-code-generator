<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Migrate;

use DrupalCodeGenerator\Command\Drupal_8\Plugin\PluginGenerator;

/**
 * Implements d8:plugin:migrate:source command.
 */
class Source extends PluginGenerator {

  protected $name = 'd8:plugin:migrate:source';
  protected $description = 'Generates migrate source plugin';
  protected $alias = 'migrate-source';
  protected $pluginLabelQuestion = FALSE;
  protected $pluginIdDefault = '{machine_name}_example';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $choices = [
      'sql' => 'SQL',
      'other' => 'Other',
    ];
    $vars['source_type'] = $this->choice('Source type', $choices);
    $vars['base_class'] = $vars['source_type'] == 'sql' ? 'SqlBase' : 'SourcePluginBase';

    $this->addFile('src/Plugin/migrate/source/{class}.php', 'd8/plugin/migrate/source');
  }

}
