<?php

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements misc:d7:module command.
 */
final class Module extends ModuleGenerator {

  protected $name = 'misc:d7:module';
  protected $description = 'Generates Drupal 7 module';
  protected $templatePath = Application::TEMPLATE_PATH . 'misc/d7';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $vars['description'] = $this->ask('Module description', 'Module description.');
    $vars['package'] = $this->ask('Package', 'Custom');

    $this->addFile('{machine_name}/{machine_name}.info', 'module-info/module-info');
    $this->addFile('{machine_name}/{machine_name}.module', 'module-file/module');
    $this->addFile('{machine_name}/{machine_name}.install', 'install-file/install');
    $this->addFile('{machine_name}/{machine_name}.admin.inc', 'admin.inc');
    $this->addFile('{machine_name}/{machine_name}.pages.inc', 'pages.inc');
    $this->addFile('{machine_name}/{machine_name|u2h}.js', 'javascript/javascript');
  }

}
