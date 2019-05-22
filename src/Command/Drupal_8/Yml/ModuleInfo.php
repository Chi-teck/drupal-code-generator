<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:yml:module-info command.
 */
class ModuleInfo extends ModuleGenerator {

  protected $name = 'd8:yml:module-info';
  protected $description = 'Generates a module info yml file';
  protected $alias = 'module-info';
  protected $label = 'Info (module)';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['description'] = $this->ask('Description', 'Module description.');
    $vars['package'] = $this->ask('Package', 'Custom');
    $vars['configure'] = $this->ask('Configuration page (route name)');
    $vars['dependencies'] = $this->ask('Dependencies (comma separated)');
    if ($vars['dependencies']) {
      $vars['dependencies'] = array_map('trim', explode(',', strtolower($vars['dependencies'])));
    }
    $this->addFile('{machine_name}.info.yml', 'd8/yml/module-info');
  }

}
