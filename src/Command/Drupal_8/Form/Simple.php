<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:form:simple command.
 */
class Simple extends Base {

  protected $name = 'd8:form:simple';
  protected $description = 'Generates simple form';
  protected $alias = 'form-simple';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $options = [
      'default_class' => 'ExampleForm',
      'default_form_id' => '{machine_name}_example',
      'default_permission' => 'access content',
      'template' => 'd8/form/simple.twig',
    ];
    $this->doInteract($input, $output, $options);
  }

}
