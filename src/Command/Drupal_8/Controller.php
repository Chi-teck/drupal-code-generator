<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
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
    $questions = Utils::defaultQuestions() + [
      'class' => [
        'Class',
        function ($vars) {
          return Utils::camelize($vars['name']) . 'Controller';
        },
      ],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $path = 'src/Controller/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/controller.twig', $vars);
  }

}
