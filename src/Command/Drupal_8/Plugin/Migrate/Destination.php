<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Migrate;

use DrupalCodeGenerator\Command\Drupal_8\Plugin\PluginGenerator;

/**
 * Implements d8:plugin:migrate:destination command.
 */
class Destination extends PluginGenerator {

  protected $name = 'd8:plugin:migrate:destination';
  protected $description = 'Generates migrate destination plugin';
  protected $alias = 'migrate-destination';
  protected $pluginLabelQuestion = FALSE;
  protected $pluginIdDefault = '{machine_name}_example';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('src/Plugin/migrate/destination/{class}.php')
      ->template('d8/plugin/migrate/destination.twig');
  }

}
