<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

/**
 * Implements plugin:menu-link command.
 */
final class MenuLink extends PluginGenerator {

  protected string $name = 'plugin:menu-link';
  protected string $description = 'Generates menu-link plugin';
  protected string $alias = 'menu-link';
  protected ?string $pluginLabelQuestion = NULL;
  protected ?string $pluginIdQuestion = NULL;
  protected string $pluginClassQuestion = 'Class';
  protected ?string $pluginClassDefault = '{machine_name|camelize}MenuLink';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('src/Plugin/Menu/{class}.php', 'menu-link');
  }

}
