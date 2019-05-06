<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\PluginGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:plugin:action command.
 */
class Action extends PluginGenerator {

  protected $name = 'd8:plugin:action';
  protected $description = 'Generates action plugin';
  protected $alias = 'action';
  protected $pluginLabelQuestion = 'Action label';
  protected $pluginLabelDefault = 'Update node title';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) :void {
    $this->collectDefault();

    $questions['category'] = new Question('Action category', 'Custom');
    $questions['configurable'] = new ConfirmationQuestion('Make the action configurable?', FALSE);

    $vars = $this->collectVars($questions);

    $this->addFile('src/Plugin/Action/{class}.php')
      ->template('d8/plugin/action.twig');

    if ($vars['configurable']) {
      $this->addFile('config/schema/{machine_name}.schema.yml')
        ->template('d8/plugin/action-schema.twig')
        ->action('append');
    }

  }

}
