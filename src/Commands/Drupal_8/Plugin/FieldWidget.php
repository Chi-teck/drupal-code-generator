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
  protected $description = 'Generates field type plugin';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Plugin name', [$this, 'defaultName']],
      'machine_name' => ['Plugin machine name', [$this, 'defaultMachineName']],
      'description' => ['Plugin description', 'TODO: Write description for the plugin'],
      'module_machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['machine_name'] . 'Widget');

    $this->files[$vars['class'] . '.php'] = $this->render('d8/plugin-field-widget.twig', $vars);
  }

}
