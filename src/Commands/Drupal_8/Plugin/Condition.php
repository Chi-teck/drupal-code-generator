<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Plugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:plugin:condition command.
 */
class Condition extends BaseGenerator {

  protected $name = 'd8:plugin:condition';
  protected $description = 'Generates condition plugin';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'plugin_label' => ['Plugin label', 'Example'],
      'plugin_id' => ['Plugin id', [$this, 'defaultPluginId']],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['plugin_label']);

    $this->files[$vars['class'] . '.php'] = $this->render('d8/plugin-condition.twig', $vars);
  }

  /**
   * Creates default plugin ID.
   */
  protected function defaultPluginId($vars) {
    return $vars['machine_name'] . '_' . $this->human2machine($vars['plugin_label']);
  }

}
