<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:views:sort command.
 */
class Style extends BaseGenerator {

  protected $name = 'd8:plugin:views:sort';
  protected $description = 'Generates views sort plugin';
  protected $alias = 'views-sort';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultPluginQuestions();

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label']);

    $this->addFile()
      ->path('src/Plugin/views/sort/{class}.php')
      ->template('d8/plugin/views/sort-plugin.twig');
  }

}
