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

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Plugin name', [$this, 'defaultName']],
      'machine_name' => ['Plugin machine name', [$this, 'defaultMachineName']],
      'description' => ['Plugin description', 'TODO: Write description for the plugin'],
      'package' => ['Package', 'custom'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $question = new ChoiceQuestion(
      '<comment>Required context:</comment>',
      ['-', 'Node', 'User', 'Term']
    );

    $vars['context'] = $this
      ->getHelper('question')
      ->ask($input, $output, $question);

    $this->files[$vars['machine_name'] . '.inc'] = $this->render($this->template, $vars);

  }

}
