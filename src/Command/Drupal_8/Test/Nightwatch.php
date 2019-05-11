<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d8:test:nightwatch command.
 */
class Nightwatch extends ModuleGenerator {

  protected $name = 'd8:test:nightwatch';
  protected $description = 'Generates a nightwatch test';
  protected $alias = 'nightwatch-test';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['test_name'] = Utils::camelize($this->ask('Test name', 'example'), FALSE);
    $this->addFile('tests/src/Nightwatch/{test_name}Test.js', 'd8/test/nightwatch');
  }

}
