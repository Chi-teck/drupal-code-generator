<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Plugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:plugin:block command.
 */
class Block extends BaseGenerator {

  protected $name = 'd8:plugin:block';
  protected $description = 'Generates block plugin';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'plugin_label' => ['Block admin label', 'Example'],
      'plugin_id' => ['Plugin ID', [$this, 'defaultPluginId']],
      'category' => ['Block category', 'Custom'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['plugin_label'] . 'Block');

    $path = $this->createPath('src/Plugin/Block/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/plugin-block.twig', $vars);
  }

}
