<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Component\Form;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:component:form:simple command.
 */
class Simple extends BaseGenerator {

  protected $name = 'd8:component:form:simple';
  protected $description = 'Generates simple form';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'class' => ['Class', [$this, 'defaultClass']],
      'form_id' => ['Form ID', [$this, 'defaultFormId']],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['class'] . '.php'] = $this->render('d8/form-simple.twig', $vars);
  }

  /**
   * Return default class name for the controller.
   */
  protected function defaultClass($vars) {
    return $this->human2class($vars['name'] . 'Form');
  }

  /**
   * Returns default form ID.
   */
  protected function defaultFormId($vars) {
    return $vars['machine_name'] . '_example';
  }

}
