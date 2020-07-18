<?php

namespace DrupalCodeGenerator\Command\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements test:browser command.
 */
final class Browser extends ModuleGenerator {

  protected $name = 'test:browser';
  protected $description = 'Generates a browser based test';
  protected $alias = 'browser-test';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', 'ExampleTest', '::validateRequiredClassName');
    $this->addFile('tests/src/Functional/{class}.php', 'browser');
  }

}
