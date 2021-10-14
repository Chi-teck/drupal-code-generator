<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;

/**
 * Implements plugin:queue-worker command.
 */
final class QueueWorker extends PluginGenerator {

  protected string $name = 'plugin:queue-worker';
  protected string $description = 'Generates queue worker plugin';
  protected string $alias = 'queue-worker';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/queue-worker';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('src/Plugin/QueueWorker/{class}.php', 'queue-worker');
  }

}
