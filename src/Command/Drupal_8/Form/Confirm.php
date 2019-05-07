<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

/**
 * Implements d8:form:confirm command.
 */
class Confirm extends FormGenerator {

  protected $name = 'd8:form:confirm';
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
    $this->addFile('src/Form/{class}.php', 'd8/form/confirm');
  }

}
