<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;

/**
 * Implements plugin:menu-link command.
 */
final class MenuLink extends PluginGenerator {

  protected string $name = 'plugin:menu-link';
  protected string $description = 'Generates menu-link plugin';
  protected string $alias = 'menu-link';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/menu-link';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('src/Plugin/Menu/{class}.php', 'menu-link');
  }

  /**
   * {@inheritdoc}
   */
  protected function askPluginLabelQuestion(): ?string {
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  protected function askPluginIdQuestion(): ?string {
    return NULL;
  }

  /**
   * Asks plugin class question.
   */
  protected function askPluginClassQuestion(array $vars): string {
    return $this->ask('Class', '{machine_name|camelize}MenuLink');
  }

}
