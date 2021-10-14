<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Test;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements test:unit command.
 */
final class Unit extends ModuleGenerator {

  protected string $name = 'test:unit';
  protected string $description = 'Generates a unit test';
  protected string $alias = 'unit-test';
  protected string $templatePath = Application::TEMPLATE_PATH . '/test/unit';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', 'ExampleTest', '::validateRequiredClassName');
    $this->addFile('tests/src/Unit/{class}.php', 'unit');
  }

}
