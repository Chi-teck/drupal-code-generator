<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Component;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:component:controller command.
 */
class Controller extends BaseGenerator {

  protected $name = 'd8:component:controller';
  protected $description = 'Generates a controller';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'class' => ['Class', [$this, 'defaultClass']],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['class'] . '.php'] = $this->render('d8/controller.twig', $vars);
  }

  /**
   * Return default class name for the controller.
   */
  protected function defaultClass($vars) {
    return $this->human2class($vars['name'] . 'Controller');
  }

}
