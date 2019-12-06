<?php

namespace DrupalCodeGenerator\Command\Misc\Drupal_7\ViewsPlugin;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements misc:d7:views-plugin:argument-default command.
 */
final class ArgumentDefault extends ModuleGenerator {

  protected $name = 'misc:d7:views-plugin:argument-default';
  protected $description = 'Generates Drupal 7 argument default views plugin';

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {
    $vars = &$this->collectDefault();
    $vars['plugin_name'] = $this->ask('Plugin name', 'Example');
    $vars['plugin_machine_name'] = $this->ask('Plugin machine name', '{plugin_name|h2m}');

    $this->addFile('{machine_name}.module')
      ->template('module')
      ->appendIfExists()
      ->headerSize(7);

    $this->addFile('views/{machine_name}.views.inc')
      ->template('views.inc')
      ->appendIfExists()
      ->headerSize(7);

    $this->addFile('views/views_plugin_argument_{plugin_machine_name}.inc')
      ->template('argument-default');
  }

}
