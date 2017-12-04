<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:template command.
 */
class Template extends BaseGenerator {

  protected $name = 'd8:template';
  protected $description = 'Generates a template';
  protected $alias = 'template';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['template_name'] = new Question('Template name', 'example');
    $questions['create_theme'] = new ConfirmationQuestion('Create theme hook?', TRUE);
    $questions['create_preprocess'] = new ConfirmationQuestion('Create preprocess hook?', TRUE);

    $vars = $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('templates/{template_name}.html.twig')
      ->template('d8/template-template.twig');

    if ($vars['create_theme'] || $vars['create_preprocess']) {
      $this->addFile()
        ->path('{machine_name}.module')
        ->template('d8/template-module.twig')
        ->action('append')
        ->headerSize(7);
    }
  }

}
