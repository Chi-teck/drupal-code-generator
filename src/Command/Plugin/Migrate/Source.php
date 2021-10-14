<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin\Migrate;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:migrate:source command.
 */
final class Source extends PluginGenerator {

  protected string $name = 'plugin:migrate:source';
  protected string $description = 'Generates migrate source plugin';
  protected string $alias = 'migrate-source';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/migrate/source';

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

  /**
   * {@inheritdoc}
   */
  protected function askPluginLabelQuestion(): ?string {
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  protected function askPluginIdQuestion(): ?string {
    return $this->ask('Plugin ID', '{machine_name}_example', '::validateRequiredMachineName');
  }

}
