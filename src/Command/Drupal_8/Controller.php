<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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
  protected function interact(InputInterface $input, OutputInterface $output) :void {
    $questions = Utils::moduleQuestions();

    $default_class = function ($vars) {
      return Utils::camelize($vars['machine_name']) . 'Controller';
    };
    $questions['class'] = new Question('Class', $default_class);

    $vars = $this->collectVars($questions);

    if ($this->confirm('Would you like to inject dependencies?', FALSE)) {
      $this->collectServices();
    }

    if ($this->confirm('Would you like to create a route for this controller?')) {
      $route_path = '/' . str_replace('_', '-', $vars['machine_name']) . '/example';
      $questions['route_name'] = new Question('Route name', '{machine_name}.example');
      $questions['route_path'] = new Question('Route path', $route_path);
      $questions['route_title'] = new Question('Route title', 'Example');
      $questions['route_permission'] = new Question('Route permission', 'access content');
      $this->collectVars($questions, $vars);
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
