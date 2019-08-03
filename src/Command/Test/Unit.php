<?php

namespace DrupalCodeGenerator\Command\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements test:unit command.
 */
final class Unit extends ModuleGenerator {

  protected $name = 'test:unit';
  protected $description = 'Generates a unit test';
  protected $alias = 'unit-test';

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'ExampleTest', '::validateRequiredClassName');
    $this->addFile('tests/src/Unit/{class}.php', 'unit');
  }

}
