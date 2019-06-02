<?php

namespace DrupalCodeGenerator\Command\Plugin\Field;

use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:field:type command.
 */
final class Type extends PluginGenerator {

  protected $name = 'plugin:field:type';
  protected $description = 'Generates field type plugin';
  protected $alias = 'field-type';
  protected $pluginClassSuffix = 'Item';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['configurable_storage'] = $this->confirm('Make the field storage configurable?', FALSE);
    $vars['configurable_instance'] = $this->confirm('Make the field instance configurable?', FALSE);
    $this->addFile('src/Plugin/Field/FieldType/{class}.php', 'plugin/field/type');
    $this->addSchemaFile()->template('plugin/field/type-schema');
  }

}
