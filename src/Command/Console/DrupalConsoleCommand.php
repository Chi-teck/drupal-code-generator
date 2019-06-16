<?php

namespace DrupalCodeGenerator\Command\Console;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements console:drupal-console-command command.
 */
final class DrupalConsoleCommand extends ModuleGenerator {

  protected $name = 'console:drupal-console-command';
  protected $description = 'Generates Drupal Console command';
  protected $alias = 'drupal-console-command';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['command_name'] = $this->ask('Command name', '{machine_name}:example');
    $vars['description'] = $this->ask('Command description', 'Command description.');
    $vars['drupal_aware'] = $this->confirm('Make the command aware of the Drupal site installation?');

    $vars['service_short_name'] = str_replace(':', '_', $vars['command_name']);
    $vars['service_name'] = '{machine_name}.{service_short_name}';
    $vars['class'] = '{service_short_name|camelize}Command';
    $vars['base_class'] = $vars['drupal_aware'] ? 'ContainerAwareCommand' : 'Command';

    $this->addFile('src/Command/{class}.php', 'command');
    $this->addServicesFile('console.services.yml')->template('services');
  }

}
