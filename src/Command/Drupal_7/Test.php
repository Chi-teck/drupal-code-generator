<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d7:test command.
 */
class Test extends ModuleGenerator {

  protected $name = 'd7:test';
  protected $description = 'Generates Drupal 7 test case';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $default_class = Utils::camelize($vars['machine_name']) . 'TestCase';
    $vars['class'] = $this->ask('Class', $default_class);
    $this->addFile('{machine_name}.test', 'd7/test');
  }

}
