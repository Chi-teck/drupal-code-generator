<?php

namespace DrupalCodeGenerator\Command\Plugin;

/**
 * Implements plugin:queue-worker command.
 */
final class QueueWorker extends PluginGenerator {

  protected $name = 'plugin:queue-worker';
  protected $description = 'Generates queue worker plugin';
  protected $alias = 'queue-worker';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('src/Plugin/QueueWorker/{class}.php', 'queue-worker');
  }

}
