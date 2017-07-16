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

    $vars = $this->collectVars($input, $output, $questions);

    $module_path = $vars['machine_name'] . '.module';
    $this->files[$module_path] = [
      'content' => $this->render('d7/views-plugin/argument-default.module.twig', $vars),
      'action' => 'append',
      'header_size' => 7,
    ];

    $views_inc_path = 'views/' . $vars['machine_name'] . '.views.inc';
    $this->files[$views_inc_path] = [
      'content' => $this->render('d7/views-plugin/argument-default-views.inc.twig', $vars),
      'action' => 'append',
      'header_size' => 7,
    ];

    $plugin_path = 'views/views_plugin_argument_' . $vars['plugin_machine_name'] . '.inc';
    $this->setFile($plugin_path, 'd7/views-plugin/argument-default.twig', $vars);
  }

}
