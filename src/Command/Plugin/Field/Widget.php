<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin\Field;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:field:widget command.
 */
final class Widget extends PluginGenerator {

  protected string $name = 'plugin:field:widget';
  protected string $description = 'Generates field widget plugin';
  protected string $alias = 'field-widget';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/field/widget';
  protected string $pluginClassSuffix = 'Widget';

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
