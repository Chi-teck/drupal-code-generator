<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Base class for Drupal 8 form generators.
 */
abstract class Base extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function doInteract(InputInterface $input, OutputInterface $output, $options) {
    $questions = Utils::defaultQuestions();
    $questions['class'] = new Question('Class', $options['default_class']);
    $questions['form_id'] = new Question('Form ID', $options['default_form_id']);

    $questions['route'] = new ConfirmationQuestion('Would you like to create a route for this form?');
    $vars = $this->collectVars($input, $output, $questions);

    if ($vars['route']) {
      $route_path = '/' . str_replace('_', '-', $vars['machine_name']) . '/example';
      $route_questions['route_name'] = new Question('Route name', '{machine_name}.example');
      $route_questions['route_path'] = new Question('Route path', $route_path);
      $route_questions['route_title'] = new Question('Route title', 'Example');
      $route_questions['route_permission'] = new Question('Route permission', $options['default_permission']);

      $this->collectVars($input, $output, $route_questions, $vars);
      $this->addFile()
        ->path('{machine_name}.routing.yml')
        ->template('d8/form/route.twig')
        ->action('append');
    }

    $this->addFile()
      ->path('src/Form/{class}.php')
      ->template($options['template']);
  }

}
