<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin\Field;

use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:field:widget command.
 */
final class Widget extends PluginGenerator {

  protected $name = 'plugin:field:widget';
  protected $description = 'Generates field widget plugin';
  protected $alias = 'field-widget';
  protected $pluginClassSuffix = 'Widget';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['configurable'] = $this->confirm('Make the widget configurable?', FALSE);
    $this->addFile('src/Plugin/Field/FieldWidget/{class}.php', 'widget');
    if ($vars['configurable']) {
      $this->addSchemaFile()->template('schema');
    }
  }

}
