<?php

namespace DrupalCodeGenerator\Command\Plugin\Migrate;

use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:migrate:source command.
 */
final class Source extends PluginGenerator {

  protected $name = 'plugin:migrate:source';
  protected $description = 'Generates migrate source plugin';
  protected $alias = 'migrate-source';
  protected $pluginLabelQuestion = FALSE;
  protected $pluginIdDefault = '{machine_name}_example';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $choices = [
      'sql' => 'SQL',
      'other' => 'Other',
    ];
    $vars['source_type'] = $this->choice('Source type', $choices);
    $vars['base_class'] = $vars['source_type'] == 'sql' ? 'SqlBase' : 'SourcePluginBase';

    $this->addFile('src/Plugin/migrate/source/{class}.php', 'source');
  }

}
