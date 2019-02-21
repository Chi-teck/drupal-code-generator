<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Migrate;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:plugin:migrate:destination command.
 */
class Destination extends BaseGenerator {

  protected $name = 'd8:plugin:migrate:destination';
  protected $description = 'Generates migrate destination plugin';
  protected $alias = 'migrate-destination';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::moduleQuestions();

    $questions['plugin_id'] = new Question('Plugin ID', '{machine_name}_example');
    $questions['plugin_id']->setValidator([Utils::class, 'validateMachineName']);
    $questions['class'] = Utils::pluginClassQuestion();

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/Plugin/migrate/destination/{class}.php')
      ->template('d8/plugin/migrate/destination.twig');
  }

}
