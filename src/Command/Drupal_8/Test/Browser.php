<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:test:browser command.
 */
class Browser extends ModuleGenerator {

  protected $name = 'd8:test:browser';
  protected $description = 'Generates a browser based test';
  protected $alias = 'browser-test';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'ExampleTest', [__CLASS__, 'validateClassName']);
    $this->addFile('tests/src/Functional/{class}.php', 'd8/test/browser');
  }

}
