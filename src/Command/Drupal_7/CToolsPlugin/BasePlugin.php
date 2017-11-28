<?php

namespace DrupalCodeGenerator\Command\Drupal_7\CToolsPlugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

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
    $questions = Utils::defaultQuestions();
    $questions['plugin_name'] = new Question('Plugin name', 'Example');
    $questions['plugin_name']->setValidator([Utils::class, 'validateRequired']);

    $default_machine_name = function ($vars) {
      return Utils::human2machine($vars['plugin_name']);
    };
    $questions['plugin_machine_name'] = new Question('Plugin machine name', $default_machine_name);
    $questions['plugin_machine_name']->setValidator([Utils::class, 'validateMachineName']);

    $questions['description'] = new Question('Plugin description', 'Plugin description.');
    $questions['category'] = new Question('Category', 'Custom');

    $questions['context'] = new ChoiceQuestion(
      'Required context',
      ['-', 'Node', 'User', 'Term']
    );

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path($this->subDirectory . '/{plugin_machine_name}.inc')
      ->template($this->template);
  }

}
