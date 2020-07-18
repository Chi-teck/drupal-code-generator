<?php

namespace DrupalCodeGenerator\Command\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements test:nightwatch command.
 */
final class Nightwatch extends ModuleGenerator {

  protected $name = 'test:nightwatch';
  protected $description = 'Generates a nightwatch test';
  protected $alias = 'nightwatch-test';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['test_name'] = Utils::camelize($this->ask('Test name', 'example'), FALSE);
    $this->addFile('tests/src/Nightwatch/{test_name}Test.js', 'nightwatch');
  }

}
