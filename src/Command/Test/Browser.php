<?php

namespace DrupalCodeGenerator\Command\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements test:browser command.
 */
class Browser extends ModuleGenerator {

  protected $name = 'test:browser';
  protected $description = 'Generates a browser based test';
  protected $alias = 'browser-test';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'ExampleTest', '::validateRequiredClassName');
    $this->addFile('tests/src/Functional/{class}.php', 'test/browser');
  }

}
