<?php declare(strict_types=1);

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
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', 'ExampleTest', '::validateRequiredClassName');
    $this->addFile('tests/src/Unit/{class}.php', 'unit');
  }

}
