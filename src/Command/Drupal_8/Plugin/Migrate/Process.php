<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Migrate;

use DrupalCodeGenerator\Command\PluginGenerator;

/**
 * Implements d8:plugin:migrate:process command.
 */
class Process extends PluginGenerator {

  protected $name = 'd8:plugin:migrate:process';
  protected $description = 'Generates migrate process plugin';
  protected $alias = 'migrate-process';
  protected $pluginLabelQuestion = FALSE;
  protected $pluginIdDefault = '{machine_name}_example';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('src/Plugin/migrate/process/{class}.php')
      ->template('d8/plugin/migrate/process.twig');
  }

}
