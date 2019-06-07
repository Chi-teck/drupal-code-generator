<?php

namespace DrupalCodeGenerator\Command\Form;

/**
 * Implements form:confirm command.
 */
final class Confirm extends FormGenerator {

  protected $name = 'form:confirm';
  protected $description = 'Generates a confirmation form';
  protected $alias = 'confirm-form';
  protected $defaultPermission = 'administer site configuration';
  protected $defaultClass = 'ExampleConfirmForm';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->generateRoute();
    $this->addFile('src/Form/{class}.php', 'form');
  }

}
