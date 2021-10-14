<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;

/**
 * Implements plugin:rest-resource command.
 */
final class RestResource extends PluginGenerator {

  protected string $name = 'plugin:rest-resource';
  protected string $description = 'Generates rest resource plugin';
  protected string $alias = 'rest-resource';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/rest-resource';
  protected string $label = 'REST resource';
  protected string $pluginClassSuffix = 'Resource';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('src/Plugin/rest/resource/{class}.php', 'rest-resource');
  }

}
