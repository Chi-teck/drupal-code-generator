<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use DrupalCodeGenerator\Command\ModuleGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:form:confirm command.
 */
class Confirm extends ModuleGenerator {

  use RouteInteractionTrait;

  protected $name = 'd8:form:confirm';
  protected $description = 'Generates a confirmation form';
  protected $alias = 'confirm-form';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) :void {
    $this->collectDefault();
    $questions['class'] = new Question('Class', 'ExampleConfirmForm');
    $this->collectVars($questions);

    $this->defaultPermission = 'administer site configuration';
    $this->routeInteraction($input, $output);

    $this->addFile('src/Form/{class}.php')
      ->template('d8/form/confirm.twig');
  }

}
