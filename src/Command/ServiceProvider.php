<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

/**
 * Implements service-provider command.
 */
final class ServiceProvider extends ModuleGenerator {

  protected string $name = 'service-provider';
  protected string $description = 'Generates a service provider';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = '{machine_name|camelize}ServiceProvider';
    $this->addFile('src/{class}.php', 'service-provider');
  }

}
