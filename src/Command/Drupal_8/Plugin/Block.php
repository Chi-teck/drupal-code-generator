<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\PluginGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:plugin:block command.
 */
class Block extends PluginGenerator {

  protected $name = 'd8:plugin:block';
  protected $description = 'Generates block plugin';
  protected $alias = 'block';
  protected $classSuffix = 'Block';
  protected $pluginLabelQuestion = 'Block admin label';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) :void {
    $vars = &$this->collectDefault();

    $questions['category'] = new Question('Block category', 'Custom');

    $questions['configurable'] = new ConfirmationQuestion('Make the block configurable?', FALSE);

    $this->collectVars($questions);

    $di_question = new ConfirmationQuestion('Would you like to inject dependencies?', FALSE);
    if ($this->ask($di_question)) {
      $this->collectServices();
    }

    $access_question = new ConfirmationQuestion('Create access callback?', FALSE);
    $vars = $this->collectVars(['access' => $access_question]);

    $this->addFile()
      ->path('src/Plugin/Block/{class}.php')
      ->template('d8/plugin/block.twig');

    if ($vars['configurable']) {
      $this->addFile()
        ->path('config/schema/{machine_name}.schema.yml')
        ->template('d8/plugin/block-schema.twig')
        ->action('append');
    }
  }

}
