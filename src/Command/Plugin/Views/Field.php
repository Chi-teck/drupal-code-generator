<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin\Views;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\Plugin\PluginGenerator;

/**
 * Implements plugin:views:field command.
 */
final class Field extends PluginGenerator {

  protected string $name = 'plugin:views:field';
  protected string $description = 'Generates views field plugin';
  protected string $alias = 'views-field';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/views/field';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['configurable'] = $this->confirm('Make the plugin configurable?', FALSE);

    $this->collectServices($vars, FALSE);

    $this->addFile('src/Plugin/views/field/{class}.php', 'field');

    if ($vars['configurable']) {
      $this->addSchemaFile('config/schema/{machine_name}.views.schema.yml')
        ->template('schema');
    }

  }

}
