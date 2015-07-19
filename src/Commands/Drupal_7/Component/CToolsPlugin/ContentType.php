<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\Component\CToolsPlugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements generate:d7:component:ctools-plugin:content-type command.
 */
class ContentType extends BaseGenerator {

  protected static $name = 'generate:d7:component:ctools-plugin:content-type';
  protected static $description = 'Generate CTools content type plugin';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Plugin name', [$this, 'defaultName']],
      'machine_name' => ['Plugin machine name', [$this, 'defaultMachineName']],
      'description' => ['Plugin description', 'TODO: Write description for the plugin'],
      'package' => ['Package', 'custom'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['machine_name'] . '.inc'] = $this->render('d7/ctools-content-type-plugin.twig', $vars);

  }

}
