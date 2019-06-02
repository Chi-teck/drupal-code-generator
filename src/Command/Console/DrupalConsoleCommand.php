<?php

namespace DrupalCodeGenerator\Command\Console;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

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
    $vars['container_aware'] = $this->confirm('Make the command aware of the drupal site installation?');

    $vars['class'] = Utils::camelize(str_replace(':', '_', $vars['command_name'])) . 'Command';
    $vars['command_trait'] = $vars['container_aware'] ? 'ContainerAwareCommandTrait' : 'CommandTrait';

    $this->addFile('src/Command/{class}.php', 'console/drupal-console-command');
  }

}
