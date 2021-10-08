<?php

namespace DrupalCodeGenerator\custom;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements custom:example command.
 */
class Example extends ModuleGenerator {

  protected string $name = 'custom:example';
  protected string $description = 'Some description';
  protected string $alias = 'example';
  protected string $templatePath = __DIR__;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars) :void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}');

    // @DCG The template should be located under directory specified in
    // $this->templatePath variable.
    $this->addFile()
      ->path('src/{class}.php')
      ->template('example');
  }

}
