<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

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
    $questions = Utils::moduleQuestions();

    $default_class = function ($vars) {
      return Utils::camelize($vars['machine_name']) . 'Controller';
    };
    $questions['class'] = new Question('Class', $default_class);

    $vars = $this->collectVars($input, $output, $questions);

    $di_question = new ConfirmationQuestion('Would you like to inject dependencies?', FALSE);
    if ($this->ask($input, $output, $di_question)) {
      $this->collectServices($input, $output);
    }

    $route_question = new ConfirmationQuestion('Would you like to create a route for this controller?');
    if ($this->ask($input, $output, $route_question)) {
      $route_path = '/' . str_replace('_', '-', $vars['machine_name']) . '/example';
      $route_questions['route_name'] = new Question('Route name', '{machine_name}.example');
      $route_questions['route_path'] = new Question('Route path', $route_path);
      $route_questions['route_title'] = new Question('Route title', 'Example');
      $route_questions['route_permission'] = new Question('Route permission', 'access content');
      $this->collectVars($input, $output, $route_questions, $vars);
      $this->addFile()
        ->path('{machine_name}.routing.yml')
        ->template('d8/controller-route.twig')
        ->action('append');
    }

    $this->addFile()
      ->path('src/Controller/{class}.php')
      ->template('d8/controller.twig');
  }

}
