<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:form:simple command.
 */
class Simple extends BaseGenerator {

  protected $name = 'd8:form:simple';
  protected $description = 'Generates simple form';
  protected $alias = 'form';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $default_class = function ($vars) {
      return Utils::camelize($vars['name'] . 'Form');
    };
    $questions['class'] = new Question('Class', $default_class);
    $default_form_id = function ($vars) {
      return $vars['machine_name'] . '_example';
    };
    $questions['form_id'] = new Question('Form ID', $default_form_id);

    $vars = $this->collectVars($input, $output, $questions);

    $path = 'src/Form/' . $vars['class'] . '.php';
    $this->setFile($path, 'd8/form/simple.twig', $vars);
  }

}
