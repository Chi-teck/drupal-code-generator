<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin\Migrate;

use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:migrate:destination command.
 */
final class Destination extends PluginGenerator {

  protected string $name = 'plugin:migrate:destination';
  protected string $description = 'Generates migrate destination plugin';
  protected string $alias = 'migrate-destination';
  protected ?string $pluginLabelQuestion = NULL;
  protected string $pluginIdDefault = '{machine_name}_example';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('src/Plugin/migrate/destination/{class}.php', 'destination');
  }

}
