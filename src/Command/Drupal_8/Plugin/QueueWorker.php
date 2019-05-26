<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:plugin:queue-worker command.
 */
class QueueWorker extends BaseGenerator {

  protected $name = 'd8:plugin:queue-worker';
  protected $description = 'Generates queue worker plugin';
  protected $alias = 'queue-worker';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::moduleQuestions() + Utils::pluginQuestions();

    $default_class = function ($vars) {
      return Utils::camelize($vars['machine_name']);
    };
    $questions['class'] = new Question('Class', $default_class);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/Plugin/QueueWorker/{class}.php')
      ->template('d8/plugin/queue-worker.twig');
  }

}
