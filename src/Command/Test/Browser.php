<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Test;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Validator\RequiredClassName;

/**
 * Implements test:browser command.
 */
final class Browser extends ModuleGenerator {

  protected string $name = 'test:browser';
  protected string $description = 'Generates a browser based test';
  protected string $alias = 'browser-test';
  protected string $templatePath = Application::TEMPLATE_PATH . '/test/browser';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', 'ExampleTest', new RequiredClassName());
    $this->addFile('tests/src/Functional/{class}.php', 'browser');
  }

}
