<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Plugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:plugin:filter command.
 */
class Filter extends BaseGenerator {

  protected $name = 'd8:plugin:filter';
  protected $description = 'Generates filter plugin';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'plugin_label' => ['Filter name', 'Example'],
      'plugin_id' => ['Filter machine name'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['plugin_label']);

    $path = $this->createPath('src/Plugin/Filter/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/plugin/filter.twig', $vars);
  }

}
