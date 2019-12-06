<?php

namespace DrupalCodeGenerator\custom;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements custom:example command.
 */
class Example extends ModuleGenerator {

  protected $name = 'custom:example';
  protected $description = 'Some description';
  protected $alias = 'example';
  protected $templatePath = __DIR__;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}');

    // @DCG The template should be located under directory specified in
    // $this->templatePath variable.
    $this->addFile()
      ->path('src/{class}.php')
      ->template('example');
  }

}
