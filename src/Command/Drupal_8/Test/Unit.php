<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:test:unit command.
 */
class Unit extends ModuleGenerator {

  protected $name = 'd8:test:unit';
  protected $description = 'Generates a unit test';
  protected $alias = 'unit-test';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'ExampleTest', [__CLASS__, 'validateClassName']);
    $this->addFile('tests/src/Unit/{class}.php', 'd8/test/unit');
  }

}
