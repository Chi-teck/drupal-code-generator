<?php

namespace DrupalCodeGenerator\Command\Form;

/**
 * Implements form:simple command.
 */
class Simple extends FormGenerator {

  protected $name = 'form:simple';
  protected $description = 'Generates simple form';
  protected $alias = 'form-simple';
  protected $defaultPermission = 'access content';
  protected $defaultClass = 'ExampleForm';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->generateRoute();
    $this->addFile('src/Form/{class}.php', 'form/simple');
  }

}
