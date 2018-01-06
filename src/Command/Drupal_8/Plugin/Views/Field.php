<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:views:field command.
 */
class Field extends BaseGenerator {

  protected $name = 'd8:plugin:views:field';
  protected $description = 'Generates views field plugin';
  protected $alias = 'views-field';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultPluginQuestions();

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label']);

    $this->addFile()
      ->path('src/Plugin/views/field/{class}.php')
      ->template('d8/plugin/views/field.twig');
  }

}
