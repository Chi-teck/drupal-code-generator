<?php

namespace DrupalCodeGenerator\Command\Plugin\Migrate;

use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:migrate:process command.
 */
final class Process extends PluginGenerator {

  protected $name = 'plugin:migrate:process';
  protected $description = 'Generates migrate process plugin';
  protected $alias = 'migrate-process';
  protected $pluginLabelQuestion = FALSE;
  protected $pluginIdDefault = '{machine_name}_example';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('src/Plugin/migrate/process/{class}.php', 'process');
  }

}
