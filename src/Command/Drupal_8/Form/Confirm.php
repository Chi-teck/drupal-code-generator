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

  use RouteInteractionTrait;

  protected $name = 'd8:form:confirm';
  protected $description = 'Generates a confirmation form';
  protected $alias = 'confirm-form';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = Utils::moduleQuestions();
    $questions['class'] = new Question('Class', 'ExampleConfirmForm');
    $this->collectVars($input, $output, $questions);

    $this->defaultPermission = 'administer site configuration';
    $this->routeInteraction($input, $output);

    $this->addFile()
      ->path('src/Form/{class}.php')
      ->template('d8/form/confirm.twig');
  }

}
