<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d7:module command.
 */
class Module extends ModuleGenerator {

  protected $name = 'd7:module';
  protected $description = 'Generates Drupal 7 module';
  protected $destination = 'modules';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['description'] = $this->ask('Module description', 'Module description.');
    $vars['package'] = $this->ask('Package', 'Custom');

    $this->addFile('{machine_name}/{machine_name}.info', 'd7/module-info');
    $this->addFile('{machine_name}/{machine_name}.module', 'd7/module');
    $this->addFile('{machine_name}/{machine_name}.install', 'd7/install');
    $this->addFile('{machine_name}/{machine_name}.admin.inc', 'd7/admin.inc');
    $this->addFile('{machine_name}/{machine_name}.pages.inc', 'd7/pages.inc');
    $this->addFile('{machine_name}/' . str_replace('_', '-', $vars['machine_name']) . '.js', 'd7/javascript');
  }

}
