<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:views:argument-default command.
 */
class ArgumentDefault extends BaseGenerator {

  protected $name = 'd8:plugin:views:argument-default';
  protected $description = 'Generates views default argument plugin';
  protected $alias = 'views-argument-default';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultPluginQuestions();

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label']);

    $this->addFile()
      ->path('src/Plugin/views/argument_default/{class}.php')
      ->template('d8/plugin/views/argument-default.twig');
  }

}
