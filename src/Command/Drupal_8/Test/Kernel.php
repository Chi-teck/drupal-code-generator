<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:test:kernel command.
 */
class Kernel extends ModuleGenerator {

  protected $name = 'd8:test:kernel';
  protected $description = 'Generates a kernel based test';
  protected $alias = 'kernel-test';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'ExampleTest', '::validateRequiredClassName');
    $this->addFile('tests/src/Kernel/{class}.php', 'd8/test/kernel');
  }

}
