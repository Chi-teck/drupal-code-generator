<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Console;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\Generator;

/**
 * Implements console:drush-command command.
 */
final class DrushCommand extends Generator {

  protected string $name = 'console:drush-command';
  protected string $description = 'Generates Drush command';
  protected string $alias = 'drush-command';
  protected string $templatePath = Application::TEMPLATE_PATH . '/console/drush-command';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $vars['command_name'] = $this->ask('Command name', '');
    $vars['alias'] = $this->ask('Command alias', \substr($vars['command_name'], 0, 3));
    $vars['description'] = $this->ask('Command description', 'Command description.');
    $vars['argument'] = $this->ask('Argument name', 'foo');
    $vars['option'] = $this->ask('Option name', 'bar');

    $directoryBaseName = \basename($this->directory);
    // The suggestion depends on whether the command global or local.
    $prefix = $directoryBaseName == 'drush' || $directoryBaseName == '.drush' ?
      $vars['command_name'] : $directoryBaseName;
    $default_command_file = \str_replace('-', '_', $prefix) . '.drush.inc';
    $vars['command_file'] = $this->ask('Command file', $default_command_file);

    [$vars['command_file_prefix']] = \explode('.drush.inc', $vars['command_file']);

    // Command callback name pattern gets shorter if command file name matches
    // command name.
    $vars['command_callback_suffix'] = $vars['command_file_prefix'] == \str_replace('-', '_', $vars['command_name'])
      ? $vars['command_file_prefix']
      : $vars['command_file_prefix'] . '_' . $vars['command_name'];

    $this->addFile('{command_file}', 'command');
  }

}
