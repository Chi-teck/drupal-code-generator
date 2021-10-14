<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;

/**
 * Implements plugin:action command.
 */
final class Action extends PluginGenerator {

  protected string $name = 'plugin:action';
  protected string $description = 'Generates action plugin';
  protected string $alias = 'action';
  protected string $pluginLabelDefault = 'Update node title';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/action';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $vars['category'] = $this->ask('Action category', 'Custom');
    $vars['configurable'] = $this->confirm('Make the action configurable?', FALSE);

    $this->addFile('src/Plugin/Action/{class}.php', 'action');

    if ($vars['configurable']) {
      $this->addSchemaFile()->template('schema');
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function askPluginLabelQuestion(): ?string {
    return $this->ask('Action label', $this->pluginLabelDefault, '::validateRequired');
  }

}
