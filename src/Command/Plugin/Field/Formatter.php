<?php

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
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['configurable'] = $this->confirm('Make the formatter configurable?', FALSE);
    $this->addFile('src/Plugin/Field/FieldFormatter/{class}.php', 'plugin/field/formatter');
    if ($vars['configurable']) {
      $this->addSchemaFile()->template('plugin/field/formatter-schema');
    }

  }

}
