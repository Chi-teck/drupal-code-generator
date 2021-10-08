<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

/**
 * Implements plugin:condition command.
 */
final class Condition extends PluginGenerator {

  protected $name = 'plugin:condition';
  protected $description = 'Generates condition plugin';
  protected $alias = 'condition';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('src/Plugin/Condition/{class}.php', 'condition');
    $this->addSchemaFile()->template('schema');
  }

}
