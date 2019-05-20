<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

/**
 * Implements d8:plugin:queue-worker command.
 */
class QueueWorker extends PluginGenerator {

  protected $name = 'd8:plugin:queue-worker';
  protected $description = 'Generates queue worker plugin';
  protected $alias = 'queue-worker';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('src/Plugin/QueueWorker/{class}.php', 'd8/plugin/queue-worker');
  }

}
