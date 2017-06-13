<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Question\Question;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
    $questions['template_name'] = new Question(
      'Template name',
      function ($vars) {
        return str_replace('_', '-', $vars['machine_name']) . '-example';
      }
    );
    $questions['create_theme'] = new Question('Create theme hook?', 'yes');
    $questions['create_preprocess'] = ['Create preprocess hook?', 'yes'];
    $vars = $this->collectVars($input, $output, $questions);

    $path = 'templates/' . $vars['template_name'] . '.html.twig';
    $this->files[$path] = $this->render('d8/template-template.twig', $vars);

    $content = '';
    if ($vars['create_theme']) {
      $content = $this->render('d8/template-theme.twig', $vars);
    }
    if ($vars['create_preprocess']) {
      $content .= "\n" . $this->render('d8/template-preprocess.twig', $vars);
    }

    if ($content) {
      $header = $this->render('d8/file-docs/module.twig', $vars);
      $this->files[$vars['machine_name'] . '.module'] = [
        'content' => $header . "\n" . $content,
        'action' => 'append',
        'header_size' => 7,
      ];
    }

  }

}
