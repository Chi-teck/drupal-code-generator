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

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultMachineName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'plugin_label' => ['Field type name', 'Example'],
      'plugin_id' => ['Field type machine name', [$this, 'defaultPluginId']],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['plugin_label'] . 'Item');

    $this->files[$vars['class'] . '.php'] = $this->render('d8/plugin-field-type.twig', $vars);
  }

  /**
   * Creates default plugin ID.
   */
  protected function defaultPluginId($vars) {
    return $vars['machine_name'] . '_' . $this->human2machine($vars['plugin_label']);
  }

}
