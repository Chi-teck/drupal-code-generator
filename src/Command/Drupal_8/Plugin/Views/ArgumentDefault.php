<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Command\PluginGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:views:argument-default command.
 */
class ArgumentDefault extends PluginGenerator {

  protected $name = 'd8:plugin:views:argument-default';
  protected $description = 'Generates views default argument plugin';
  protected $alias = 'views-argument-default';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) :void {
    $vars = &$this->collectDefault();
    $vars['configurable'] = $this->confirm('Make the plugin configurable?', FALSE);

    if ($this->confirm('Would you like to inject dependencies?', FALSE)) {
      $this->collectServices();
    }

    $this->addFile('src/Plugin/views/argument_default/{class}.php')
      ->template('d8/plugin/views/argument-default.twig');

    if ($vars['configurable']) {
      $this->addFile('config/schema/{machine_name}.views.schema.yml')
        ->template('d8/plugin/views/argument-default-schema.twig')
        ->action('append');
    }
  }

}
