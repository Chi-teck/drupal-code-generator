<?php

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:module-info command.
 */
final class ModuleInfo extends ModuleGenerator {

  protected $name = 'yml:module-info';
  protected $description = 'Generates a module info yml file';
  protected $alias = 'module-info';
  protected $label = 'Info (module)';

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {
    $vars = &$this->collectDefault();
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
