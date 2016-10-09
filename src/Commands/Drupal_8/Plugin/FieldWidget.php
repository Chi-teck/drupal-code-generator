<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Plugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:plugin:field-widget command.
 */
class FieldWidget extends BaseGenerator {

  protected $name = 'd8:plugin:field-widget';
  protected $description = 'Generates widget plugin';
  protected $alias = 'widget';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'plugin_label' => ['Widget name', 'Example'],
      'plugin_id' => ['Widget machine name'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['plugin_label'] . 'Widget');

    $path = $this->createPath('src/Plugin/Field/FieldWidget/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/plugin/field-widget.twig', $vars);
  }

}
