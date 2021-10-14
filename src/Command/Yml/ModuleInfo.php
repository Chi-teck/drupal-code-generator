<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:module-info command.
 */
final class ModuleInfo extends ModuleGenerator {

  protected string $name = 'yml:module-info';
  protected string $description = 'Generates a module info yml file';
  protected string $alias = 'module-info';
  protected string $label = 'Info (module)';
  protected string $templatePath = Application::TEMPLATE_PATH . '/yml/module-info';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['description'] = $this->ask('Description', 'Module description.', '::validateRequired');
    $vars['package'] = $this->ask('Package', 'Custom');
    $vars['configure'] = $this->ask('Configuration page (route name)');
    $vars['dependencies'] = $this->ask('Dependencies (comma separated)');
    if ($vars['dependencies']) {
      $vars['dependencies'] = \array_map('trim', \explode(',', \strtolower($vars['dependencies'])));
    }
    $this->addFile('{machine_name}.info.yml', 'module-info');
  }

}
