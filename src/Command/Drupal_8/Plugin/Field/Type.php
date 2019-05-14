<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Command\Drupal_8\Plugin\PluginGenerator;

/**
 * Implements d8:plugin:field:type command.
 */
class Type extends PluginGenerator {

  protected $name = 'd8:plugin:field:type';
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
    $this->addFile('src/Plugin/Field/FieldType/{class}.php', 'd8/plugin/field/type');
    $this->addSchemaFile()->template('d8/plugin/field/type-schema');
  }

}
