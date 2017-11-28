<?php

namespace DrupalCodeGenerator\Command\Drupal_7\ViewsPlugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d7:views-plugin:argument-default command.
 */
class ArgumentDefault extends BaseGenerator {

  protected $name = 'd7:views-plugin:argument-default';
  protected $description = 'Generates Drupal 7 argument default views plugin';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['plugin_name'] = new Question('Plugin name', 'Example');
    $default_machine_name = function ($vars) {
      return Utils::human2machine($vars['plugin_name']);
    };
    $questions['plugin_machine_name'] = new Question('Plugin machine name', $default_machine_name);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('{machine_name}.module')
      ->template('d7/views-plugin/argument-default.module.twig')
      ->action('append')
      ->headerSize(7);

    $this->addFile()
      ->path('views/{machine_name}.views.inc')
      ->template('d7/views-plugin/argument-default-views.inc.twig')
      ->action('append')
      ->headerSize(7);

    $this->addFile()
      ->path('views/views_plugin_argument_{plugin_machine_name}.inc')
      ->template('d7/views-plugin/argument-default.twig');
  }

}
