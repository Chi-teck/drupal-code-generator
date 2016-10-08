<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Plugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:plugin:field-formatter command.
 */
class FieldFormatter extends BaseGenerator {

  protected $name = 'd8:plugin:field-formatter';
  protected $description = 'Generates formatter plugin';
  protected $alias = 'formatter';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'plugin_label' => ['Formatter name', 'Example'],
      'plugin_id' => ['Formatter machine name'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['plugin_label'] . 'Formatter');

    $path = $this->createPath('src/Plugin/Field/FieldFormatter/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/plugin/field-formatter.twig', $vars);
  }

}
