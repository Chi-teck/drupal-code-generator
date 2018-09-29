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
    $questions = Utils::defaultQuestions();
    $default_class = function ($vars) {
      return Utils::camelize($vars['name']) . 'Controller';
    };
    $questions['class'] = new Question('Class', $default_class);
    $questions['di'] = new ConfirmationQuestion('Inject dependencies?', FALSE);
    $questions['route'] = new ConfirmationQuestion('Would you like to create a route for this controller?');
    $vars = $this->collectVars($input, $output, $questions);

    if ($vars['route']) {
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
