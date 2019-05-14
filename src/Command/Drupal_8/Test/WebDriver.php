<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:test:webdriver command.
 */
class WebDriver extends ModuleGenerator {

  protected $name = 'd8:test:webdriver';
  protected $description = 'Generates a test that supports JavaScript';
  protected $alias = 'webdriver-test';
  protected $label = 'WebDriver';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'ExampleTest', '::validateClassName');
    $this->addFile('tests/src/FunctionalJavascript/{class}.php', 'd8/test/webdriver');
  }

}
