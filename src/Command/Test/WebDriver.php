<?php

namespace DrupalCodeGenerator\Command\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements test:webdriver command.
 */
final class WebDriver extends ModuleGenerator {

  protected $name = 'test:webdriver';
  protected $description = 'Generates a test that supports JavaScript';
  protected $alias = 'webdriver-test';
  protected $label = 'WebDriver';

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'ExampleTest', '::validateRequiredClassName');
    $this->addFile('tests/src/FunctionalJavascript/{class}.php', 'webdriver');
  }

}
