<?php

namespace DrupalCodeGenerator\Command\Drupal_7\ViewsPlugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
    $questions = Utils::defaultQuestions() + [
      'plugin_name' => ['Plugin name', 'Example'],
      'plugin_machine_name' => [
        'Plugin machine name',
        function ($vars) {
          return Utils::human2machine($vars['plugin_name']);
        },
      ],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $this->files['views_plugin_argument_' . $vars['plugin_machine_name'] . '.inc'] = $this->render('d7/views-argument-default.twig', $vars);
  }

}
