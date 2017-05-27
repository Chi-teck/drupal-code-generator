<?php

namespace DrupalCodeGenerator\Command\Drupal_7\CToolsPlugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Base class for d7:ctools-plugin commands.
 */
abstract class BasePlugin extends BaseGenerator {

  protected $template;
  protected $subDirectory;

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

    $this->files[$this->subDirectory . '/' . $vars['plugin_machine_name'] . '.inc'] = $this->render($this->template, $vars);
  }

}
