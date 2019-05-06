<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\PluginGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:condition command.
 */
class Condition extends PluginGenerator {

  protected $name = 'd8:plugin:condition';
  protected $description = 'Generates condition plugin';
  protected $alias = 'condition';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) :void {
    $this->collectDefault();

    $this->addFile('src/Plugin/Condition/{class}.php')
      ->template('d8/plugin/condition.twig');

    $this->addFile('config/schema/{machine_name}.schema.yml')
      ->template('d8/plugin/condition-schema.twig')
      ->action('append');
  }

}
