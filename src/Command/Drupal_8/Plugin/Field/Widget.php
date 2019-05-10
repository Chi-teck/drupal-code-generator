<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Command\Drupal_8\Plugin\PluginGenerator;

/**
 * Implements d8:plugin:field:widget command.
 */
class Widget extends PluginGenerator {

  protected $name = 'd8:plugin:field:widget';
  protected $description = 'Generates field widget plugin';
  protected $alias = 'field-widget';
  protected $pluginClassSuffix = 'Widget';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['configurable'] = $this->confirm('Make the widget configurable?', FALSE);

    $this->addFile('src/Plugin/Field/FieldWidget/{class}.php')
      ->template('d8/plugin/field/widget');

    if ($vars['configurable']) {
      $this->addFile('config/schema/{machine_name}.schema.yml')
        ->template('d8/plugin/field/widget-schema')
        ->action('append');
    }
  }

}
