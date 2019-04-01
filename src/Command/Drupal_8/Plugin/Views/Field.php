<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Implements d8:plugin:views:field command.
 */
class Field extends BaseGenerator {

  protected $name = 'd8:plugin:views:field';
  protected $description = 'Generates views field plugin';
  protected $alias = 'views-field';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::moduleQuestions() + Utils::pluginQuestions();
    $questions['configurable'] = new ConfirmationQuestion('Make the plugin configurable?', FALSE);
    $vars = $this->collectVars($input, $output, $questions);

    $di_question = new ConfirmationQuestion('Would you like to inject dependencies?', FALSE);
    if ($this->ask($input, $output, $di_question)) {
      $this->collectServices($input, $output);
    }

    $this->addFile()
      ->path('src/Plugin/views/field/{class}.php')
      ->template('d8/plugin/views/field.twig');

    if ($vars['configurable']) {
      $this->addFile()
        ->path('config/schema/{machine_name}.views.schema.yml')
        ->template('d8/plugin/views/field-schema.twig')
        ->action('append');
    }

  }

}
