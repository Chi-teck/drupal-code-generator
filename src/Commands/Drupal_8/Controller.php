<?php

namespace DrupalCodeGenerator\Commands\Drupal_8;

use DrupalCodeGenerator\Commands\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:controller command.
 */
class Controller extends BaseGenerator {

  protected $name = 'd8:controller';
  protected $description = 'Generates a controller';
  protected $alias = 'controller';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'class' => ['Class', [__CLASS__, 'defaultClass']],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $path = 'src/Controller/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/controller.twig', $vars);
  }

  /**
   * Return default class name for the controller.
   */
  protected static function defaultClass($vars) {
    return self::human2class($vars['name'] . 'Controller');
  }

}
