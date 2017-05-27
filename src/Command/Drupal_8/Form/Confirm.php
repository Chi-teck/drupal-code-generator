<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:form:confirm command.
 */
class Confirm extends BaseGenerator {

  protected $name = 'd8:form:confirm';
  protected $description = 'Generates a confirmation form';
  protected $alias = 'confirm-form';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'class' => ['Class', 'ExampleConfirmForm'],
      'form_id' => [
        'Form ID',
        function ($vars) {
          return $vars['machine_name'] . ' _example_confirm';
        },
      ],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $path = 'src/Form/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/form/confirm.twig', $vars);
  }

}
