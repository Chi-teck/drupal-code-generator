<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:plugin:action command.
 */
class Action extends BaseGenerator {

  protected $name = 'd8:plugin:action';
  protected $description = 'Generates action plugin';
  protected $alias = 'action';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::moduleQuestions() + Utils::pluginQuestions();

    // Plugin label should declare an action.
    $questions['plugin_label'] = new Question('Action label', 'Update node title');
    $questions['category'] = new Question('Action category', 'Custom');
    $questions['configurable'] = new ConfirmationQuestion('Make the action configurable?', FALSE);

    $vars = $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/Plugin/Action/{class}.php')
      ->template('d8/plugin/action.twig');

    if ($vars['configurable']) {
      $this->addFile()
        ->path('config/schema/{machine_name}.schema.yml')
        ->template('d8/plugin/action-schema.twig')
        ->action('append');
    }

  }

}
