<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

/**
 * Implements d8:form:simple command.
 */
class Simple extends FormGenerator {

  protected $name = 'd8:form:simple';
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
    $this->addFile('src/Form/{class}.php', 'd8/form/simple');
  }

}
