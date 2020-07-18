<?php

namespace DrupalCodeGenerator\Command\Plugin\Migrate;

use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:migrate:destination command.
 */
final class Destination extends PluginGenerator {

  protected $name = 'plugin:migrate:destination';
  protected $description = 'Generates migrate destination plugin';
  protected $alias = 'migrate-destination';
  protected $pluginLabelQuestion = FALSE;
  protected $pluginIdDefault = '{machine_name}_example';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('src/Plugin/migrate/destination/{class}.php', 'destination');
  }

}
