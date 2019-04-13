<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Implements d8:plugin:views:style command.
 */
class Style extends BaseGenerator {

  protected $name = 'd8:plugin:views:style';
  protected $description = 'Generates views style plugin';
  protected $alias = 'views-style';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::moduleQuestions() + Utils::pluginQuestions();
    $questions['configurable'] = new ConfirmationQuestion('Make the plugin configurable?', TRUE);

    $vars = $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/Plugin/views/style/{class}.php')
      ->template('d8/plugin/views/style-plugin.twig');

    $this->addFile()
      ->path('templates/views-style-' . str_replace('_', '-', $vars['plugin_id']) . '.html.twig')
      ->template('d8/plugin/views/style-template.twig');

    $this->addFile()
      ->path('{machine_name}.module')
      ->headerTemplate('d8/file-docs/module.twig')
      ->template('d8/plugin/views/style-preprocess.twig')
      ->action('append')
      ->headerSize(7);

    if ($vars['configurable']) {
      $this->addFile()
        ->path('config/schema/{machine_name}.schema.yml')
        ->template('d8/plugin/views/style-schema.twig')
        ->action('append');
    }

  }

}
