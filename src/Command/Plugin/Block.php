<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;

/**
 * Implements plugin:block command.
 */
final class Block extends PluginGenerator {

  protected string $name = 'plugin:block';
  protected string $description = 'Generates block plugin';
  protected string $alias = 'block';
  protected string $pluginClassSuffix = 'Block';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/block';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $vars['category'] = $this->ask('Block category', 'Custom');
    $vars['configurable'] = $this->confirm('Make the block configurable?', FALSE);

    $this->collectServices($vars, FALSE);

    $vars['access'] = $this->confirm('Create access callback?', FALSE);

    $this->addFile('src/Plugin/Block/{class}.php', 'block');

    if ($vars['configurable']) {
      $this->addSchemaFile()->template('schema');
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function askPluginLabelQuestion(): ?string {
    return $this->ask('Block admin label', 'Example', '::validateRequired');
  }

}
