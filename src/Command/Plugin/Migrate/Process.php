<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin\Migrate;

use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:migrate:process command.
 */
final class Process extends PluginGenerator {

  protected string $name = 'plugin:migrate:process';
  protected string $description = 'Generates migrate process plugin';
  protected string $alias = 'migrate-process';
  protected $pluginLabelQuestion = FALSE;
  protected $pluginIdDefault = '{machine_name}_example';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('src/Plugin/migrate/process/{class}.php', 'process');
  }

}
