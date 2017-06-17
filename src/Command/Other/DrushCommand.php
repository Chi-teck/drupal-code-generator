<?php

namespace DrupalCodeGenerator\Command\Other;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

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
  protected function interact(InputInterface $input, OutputInterface $output) {

    $default_alias = function ($vars) {
      return substr($vars['command_name'], 0, 3);
    };

    $default_command_file = function ($vars) {
      $directoryBaseName = basename($this->directory);
      // The suggestion depends on whether the command global or local.
      $prefix = $directoryBaseName == 'drush' || $directoryBaseName == '.drush' ?
        $vars['command_name'] : $directoryBaseName;
      return str_replace('-', '_', $prefix) . '.drush.inc';
    };

    $questions = [
      'command_name' => new Question('Command name', ''),
      'alias' => new Question('Command alias', $default_alias),
      'description' => new Question('Command description', 'Command description.'),
      'argument' => new Question('Argument name', 'foo'),
      'option' => new Question('Option name', 'bar'),
      'command_file' => new Question('Command file', $default_command_file),
    ];

    $vars = $this->collectVars($input, $output, $questions);

    list($vars['command_file_prefix']) = explode('.drush.inc', $vars['command_file']);

    // Command callback name pattern gets shorter if command file name matches
    // command name.
    $vars['command_callback_suffix'] = $vars['command_file_prefix'] == str_replace('-', '_', $vars['command_name'])
      ? $vars['command_file_prefix']
      : $vars['command_file_prefix'] . '_' . $vars['command_name'];

    $this->setFile($vars['command_file'], 'other/drush-command.twig', $vars);
  }

}
