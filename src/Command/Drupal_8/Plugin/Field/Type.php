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
  protected $classSuffix = 'Item';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['configurable_storage'] = $this->confirm('Make the field storage configurable?', FALSE);
    $vars['configurable_instance'] = $this->confirm('Make the field instance configurable?', FALSE);

    $this->addFile()
      ->path('src/Plugin/Field/FieldType/{class}.php')
      ->template('d8/plugin/field/type.twig');

    $this->addFile()
      ->path('config/schema/{machine_name}.schema.yml')
      ->template('d8/plugin/field/type-schema.twig')
      ->action('append');
  }

}
