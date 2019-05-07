<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d7:module-info command.
 */
class ModuleInfo extends ModuleGenerator {

  protected $name = 'd7:module-info';
  protected $description = 'Generates Drupal 7 info file for a module';
  protected $label = 'Info (module)';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['description'] = $this->ask('Module description', 'Module description.');
    $vars['package'] = $this->ask('Package', 'Custom');
    $this->addFile('{machine_name}.info', 'd7/module-info');
  }

}
