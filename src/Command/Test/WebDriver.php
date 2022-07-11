<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Test;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Validator\RequiredClassName;

/**
 * Implements test:webdriver command.
 */
final class WebDriver extends ModuleGenerator {

  protected string $name = 'test:webdriver';
  protected string $description = 'Generates a test that supports JavaScript';
  protected string $alias = 'webdriver-test';
  protected string $label = 'WebDriver';
  protected string $templatePath = Application::TEMPLATE_PATH . '/test/webdriver';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', 'ExampleTest', new RequiredClassName());
    $this->addFile('tests/src/FunctionalJavascript/{class}.php', 'webdriver');
  }

}
