<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Command\Drupal_8\Plugin\PluginGenerator;

/**
 * Implements d8:plugin:field:formatter command.
 */
class Formatter extends PluginGenerator {

  protected $name = 'd8:plugin:field:formatter';
  protected $description = 'Generates field formatter plugin';
  protected $alias = 'field-formatter';

  protected $pluginClassSuffix = 'Formatter';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['configurable'] = $this->confirm('Make the formatter configurable?', FALSE);
    $this->addFile('src/Plugin/Field/FieldFormatter/{class}.php', 'd8/plugin/field/formatter');
    if ($vars['configurable']) {
      $this->addSchemaFile()->template('d8/plugin/field/formatter-schema');
    }

  }

}
