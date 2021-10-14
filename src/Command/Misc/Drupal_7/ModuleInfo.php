<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements misc:d7:module-info command.
 */
final class ModuleInfo extends ModuleGenerator {

  protected string $name = 'misc:d7:module-info';
  protected string $description = 'Generates Drupal 7 info file for a module';
  protected string $label = 'Info (module)';
  protected string $templatePath = Application::TEMPLATE_PATH . '/misc/d7/module-info';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['description'] = $this->ask('Module description', 'Module description.');
    $vars['package'] = $this->ask('Package', 'Custom');
    $this->addFile('{machine_name}.info', 'module-info');
  }

}
