<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements test:kernel command.
 */
final class Kernel extends ModuleGenerator {

  protected string $name = 'test:kernel';
  protected string $description = 'Generates a kernel based test';
  protected string $alias = 'kernel-test';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', 'ExampleTest', '::validateRequiredClassName');
    $this->addFile('tests/src/Kernel/{class}.php', 'kernel');
  }

}
