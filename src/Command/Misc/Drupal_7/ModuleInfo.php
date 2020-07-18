<?php

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements misc:d7:module-info command.
 */
final class ModuleInfo extends ModuleGenerator {

  protected $name = 'misc:d7:module-info';
  protected $description = 'Generates Drupal 7 info file for a module';
  protected $label = 'Info (module)';

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
