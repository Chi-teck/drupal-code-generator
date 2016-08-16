<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Plugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:plugin:views-argument-default command.
 */
class ViewsArgumentDefault extends BaseGenerator {

  protected $name = 'd8:plugin:views-argument-default';
  protected $description = 'Generates views default argument plugin';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'plugin_label' => ['Plugin label', 'Example'],
      'plugin_id' => ['Plugin id'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['plugin_label']);

    $path = $this->createPath('src/Plugin/views/argument_default/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/plugin/views-argument-default.twig', $vars);
  }

}
