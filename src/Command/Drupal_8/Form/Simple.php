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
  protected $alias = 'form';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $options['default_class'] = 'ExampleForm';
    $options['default_form_id'] = function ($vars) {
      return $vars['machine_name'] . '_example';
    };
    $options['default_permission'] = 'access content';
    $options['template'] = 'd8/form/simple.twig';
    $this->doInteract($input, $output, $options);
  }

}
