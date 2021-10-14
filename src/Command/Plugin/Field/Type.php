<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin\Field;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:field:type command.
 */
final class Type extends PluginGenerator {

  protected string $name = 'plugin:field:type';
  protected string $description = 'Generates field type plugin';
  protected string $alias = 'field-type';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/field/type';
  protected string $pluginClassSuffix = 'Item';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['configurable_storage'] = $this->confirm('Make the field storage configurable?', FALSE);
    $vars['configurable_instance'] = $this->confirm('Make the field instance configurable?', FALSE);
    $this->addFile('src/Plugin/Field/FieldType/{class}.php', 'type');
    $this->addSchemaFile()->template('schema');
  }

}
