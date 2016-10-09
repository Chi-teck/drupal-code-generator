<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Plugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

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

    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'plugin_label' => ['Plugin label', 'Example'],
      'plugin_id' => ['Plugin ID'],
      'category' => ['Action category', 'Custom'],
      'configurable' => ['Make the action configurable', 'no']
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['plugin_label']);

    $path = $this->createPath('src/Plugin/Action/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/plugin/action.twig', $vars);
  }

}
