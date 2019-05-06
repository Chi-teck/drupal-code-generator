<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use DrupalCodeGenerator\Command\ModuleGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:form:simple command.
 */
class Simple extends ModuleGenerator {

  use RouteInteractionTrait;

  protected $name = 'd8:form:simple';
  protected $description = 'Generates simple form';
  protected $alias = 'form-simple';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) :void {
    $this->collectDefault();

    $questions['class'] = new Question('Class', 'ExampleForm');
    $this->collectVars($questions);

    $this->defaultPermission = 'access content';
    $this->routeInteraction($input, $output);

    $this->addFile('src/Form/{class}.php')
      ->template('d8/form/simple.twig');
  }

}
