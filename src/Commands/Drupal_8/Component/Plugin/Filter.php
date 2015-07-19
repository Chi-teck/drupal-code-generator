<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Component\Plugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Class Info
 * @package DrupalCodeGenerator\Commands\Drupal_8\Component
 *
 * @TODO: write test.
 */
class Filter extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected static $name = 'generate:d8:component:plugin:filter';

  /**
   * {@inheritdoc}
   */
  protected static $description = 'Generates filter plugin';

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
    $vars['class'] = $this->human2class($vars['machine_name']);

    $this->files[$vars['class'] . '.php'] = $this->render('d8/plugin-filter.twig', $vars);
  }

}
