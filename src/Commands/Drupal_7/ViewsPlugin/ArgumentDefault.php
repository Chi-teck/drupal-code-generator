<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\ViewsPlugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

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

    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'plugin_name' => ['Plugin name', 'Example'],
      'plugin_machine_name' => [
        'Plugin machine name', [$this, 'defaultPluginMachineName'],
      ],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['project_type'] = 'module';

    $this->files['views_plugin_argument_' . $vars['plugin_machine_name'] . '.inc'] = $this->render('d7/views-argument-default.twig', $vars);

  }

  /**
   * Returns default value for the plugin machine name question.
   */
  protected function defaultPluginMachineName($vars) {
    return $this->defaultMachineName(['name' => $vars['plugin_name']]);
  }

}
