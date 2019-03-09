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

  use RouteInteractionTrait;

  protected $name = 'd8:form:simple';
  protected $description = 'Generates simple form';
  protected $alias = 'form-simple';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = Utils::moduleQuestions();
    $questions['class'] = new Question('Class', 'ExampleForm');
    $this->collectVars($input, $output, $questions);

    $this->defaultPermission = 'access content';
    $this->routeInteraction($input, $output);

    $this->addFile()
      ->path('src/Form/{class}.php')
      ->template('d8/form/simple.twig');
  }

}
