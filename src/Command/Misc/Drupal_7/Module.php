<?php

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements misc:d7:module command.
 */
final class Module extends ModuleGenerator {

  protected $name = 'misc:d7:module';
  protected $description = 'Generates Drupal 7 module';
  protected $destination = 'modules';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['description'] = $this->ask('Module description', 'Module description.');
    $vars['package'] = $this->ask('Package', 'Custom');

    $this->addFile('{machine_name}/{machine_name}.info', 'misc/d7/module-info');
    $this->addFile('{machine_name}/{machine_name}.module', 'misc/d7/module');
    $this->addFile('{machine_name}/{machine_name}.install', 'misc/d7/install');
    $this->addFile('{machine_name}/{machine_name}.admin.inc', 'misc/d7/admin.inc');
    $this->addFile('{machine_name}/{machine_name}.pages.inc', 'misc/d7/pages.inc');
    $this->addFile('{machine_name}/{machine_name|u2h}.js', 'misc/d7/javascript');
  }

}
