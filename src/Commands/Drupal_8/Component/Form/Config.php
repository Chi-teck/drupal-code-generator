<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Component\Form;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:component:form:config command.
 */
class Config extends BaseGenerator {

  protected $name = 'd8:component:form:config';
  protected $description = 'Generates configuration form';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'class' => ['Class', 'SettingsForm'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['class'] . '.php'] = $this->render('d8/form-config.twig', $vars);
  }

}
