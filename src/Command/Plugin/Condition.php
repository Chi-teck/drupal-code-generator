<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;

/**
 * Implements plugin:condition command.
 */
final class Condition extends PluginGenerator {

  protected string $name = 'plugin:condition';
  protected string $description = 'Generates condition plugin';
  protected string $alias = 'condition';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/condition';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('src/Plugin/Condition/{class}.php', 'condition');
    $this->addSchemaFile()->template('schema');
  }

}
