<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
    $questions = Utils::defaultQuestions() + [
      'plugin_label' => ['Plugin label', 'Example'],
      'plugin_id' => ['Plugin id'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label']);

    $plugin_path = 'src/Plugin/views/style/' . $vars['class'] . '.php';
    $this->files[$plugin_path] = $this->render('d8/plugin/views/style-plugin.twig', $vars);

    $template_path = 'templates/' . 'views-style-' . str_replace('_', '-', $vars['plugin_id']) . '.html.twig';
    $this->files[$template_path] = $this->render('d8/plugin/views/style-template.twig', $vars);

    $this->files[$vars['machine_name'] . '.module'] = [
      'file_doc' => $this->render('d8/file-docs/module.twig', $vars),
      'content' => $this->render('d8/plugin/views/style-preprocess.twig', $vars),
      'merge_type' => 'append',
    ];
  }

}
