<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\CToolsPlugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Base class for d7:ctools-plugin commands.
 */
abstract class BasePlugin extends BaseGenerator {

  protected $template;
  protected $directory;

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'plugin_name' => ['Plugin name', [$this, 'defaultName']],
      'plugin_machine_name' => [
        'Plugin machine name', [$this, 'defaultPluginMachineName'],
      ],
      'description' => ['Plugin description', 'TODO: Write description for the plugin'],
      'category' => ['Category', 'Custom'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $question = new ChoiceQuestion(
      '<comment>Required context:</comment>',
      ['-', 'Node', 'User', 'Term']
    );

    $vars['context'] = $this
      ->getHelper('question')
      ->ask($input, $output, $question);

    $this->files[$this->directory . '/' . $vars['plugin_machine_name'] . '.inc'] = $this->render($this->template, $vars);

  }

  /**
   * Returns default value for the plugin machine name question.
   */
  protected function defaultPluginMachineName($vars) {
    return self::human2machine($vars['plugin_name']);
  }

}
