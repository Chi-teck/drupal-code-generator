<?php

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:services command.
 */
final class Services extends ModuleGenerator {

  protected $name = 'yml:services';
  protected $description = 'Generates a services yml file';
  protected $alias = 'services';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = '{machine_name|camelize}';
    $this->addFile('{machine_name}.services.yml', 'services');
  }

}
