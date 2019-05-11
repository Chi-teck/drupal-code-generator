<?php

namespace DrupalCodeGenerator\Command\Other;

use DrupalCodeGenerator\Command\BaseGenerator;

/**
 * Implements other:drush-command command.
 */
class DrushCommand extends BaseGenerator {

  protected $name = 'other:drush-command';
  protected $description = 'Generates Drush command';
  protected $alias = 'drush-command';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->vars;

    $vars['command_name'] = $this->ask('Command name', '');
    $vars['alias'] = $this->ask('Command alias', substr($vars['command_name'], 0, 3));
    $vars['description'] = $this->ask('Command description', 'Command description.');
    $vars['argument'] = $this->ask('Argument name', 'foo');
    $vars['option'] = $this->ask('Option name', 'bar');

    $directoryBaseName = basename($this->directory);
    // The suggestion depends on whether the command global or local.
    $prefix = $directoryBaseName == 'drush' || $directoryBaseName == '.drush' ?
      $vars['command_name'] : $directoryBaseName;
    $default_command_file = str_replace('-', '_', $prefix) . '.drush.inc';
    $vars['command_file'] = $this->ask('Command file', $default_command_file);

    list($vars['command_file_prefix']) = explode('.drush.inc', $vars['command_file']);

    // Command callback name pattern gets shorter if command file name matches
    // command name.
    $vars['command_callback_suffix'] = $vars['command_file_prefix'] == str_replace('-', '_', $vars['command_name'])
      ? $vars['command_file_prefix']
      : $vars['command_file_prefix'] . '_' . $vars['command_name'];

    $this->addFile('{command_file}', 'other/drush-command');
  }

}
