<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Form;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:form:confirm command.
 */
class Confirm extends BaseGenerator {

  protected $name = 'd8:form:confirm';
  protected $description = 'Generates a confirmation form';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'class' => ['Class', 'ExampleConfirmForm'],
      'form_id' => ['Form ID', [$this, 'defaultFormId']],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['class'] . '.php'] = $this->render('d8/form-confirm.twig', $vars);
  }

  /**
   * Returns default form ID.
   */
  protected function defaultFormId($vars) {
    return $vars['machine_name'] . '_example_confirm';
  }

}
