<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin\Field;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:field:formatter command.
 */
final class Formatter extends PluginGenerator {

  protected string $name = 'plugin:field:formatter';
  protected string $description = 'Generates field formatter plugin';
  protected string $alias = 'field-formatter';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/field/formatter';
  protected string $pluginClassSuffix = 'Formatter';

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
