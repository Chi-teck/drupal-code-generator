<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Plugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:plugin:field-type command.
 */
class FieldType extends BaseGenerator {

  protected $name = 'd8:plugin:field-type';
  protected $description = 'Generates field type plugin';
  protected $alias = 'field';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'plugin_label' => ['Field type name', 'Example'],
      'plugin_id' => ['Field type machine name'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['plugin_label'] . 'Item');

    $path = $this->createPath('src/Plugin/Field/FieldType/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/plugin/field-type.twig', $vars);
  }

}
