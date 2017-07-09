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

    $path = 'templates/' . $vars['template_name'] . '.html.twig';
    $this->setFile($path, 'd8/template-template.twig', $vars);
    if ($vars['create_theme'] || $vars['create_preprocess']) {
      $this->files[$vars['machine_name'] . '.module'] = [
        'content' => $this->render('d8/template-module.twig', $vars),
        'action' => 'append',
        'header_size' => 7,
      ];
    }
  }

}
