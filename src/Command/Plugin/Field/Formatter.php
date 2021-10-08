<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin\Field;

use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:field:formatter command.
 */
final class Formatter extends PluginGenerator {

  protected $name = 'plugin:field:formatter';
  protected $description = 'Generates field formatter plugin';
  protected $alias = 'field-formatter';
  protected $pluginClassSuffix = 'Formatter';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['configurable'] = $this->confirm('Make the formatter configurable?', FALSE);
    $this->addFile('src/Plugin/Field/FieldFormatter/{class}.php', 'formatter');
    if ($vars['configurable']) {
      $this->addSchemaFile()->template('schema');
    }

  }

}
