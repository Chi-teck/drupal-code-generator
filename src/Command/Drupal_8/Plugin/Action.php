<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:action command.
 */
class Action extends BaseGenerator {

  protected $name = 'd8:plugin:action';
  protected $description = 'Generates action plugin';
  protected $alias = 'action';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultPluginQuestions() + [
      'category' => ['Action category', 'Custom'],
      'configurable' => ['Make the action configurable?', 'no'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label']);

    $path = 'src/Plugin/Action/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/plugin/action.twig', $vars);
  }

}
