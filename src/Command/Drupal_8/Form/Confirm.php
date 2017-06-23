<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

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
    $questions = Utils::defaultQuestions();
    $questions['class'] = new Question('Class', 'ExampleConfirmForm');
    $default_form_id = function ($vars) {
      return $vars['machine_name'] . '_example_confirm';
    };
    $questions['form_id'] = new Question('Form ID', $default_form_id);

    $vars = $this->collectVars($input, $output, $questions);

    $path = 'src/Form/' . $vars['class'] . '.php';
    $this->setFile($path, 'd8/form/confirm.twig', $vars);
  }

}
