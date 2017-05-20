<?php

namespace DrupalCodeGenerator\Commands\Other;

use DrupalCodeGenerator\Commands\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
    $questions = [
      'command_name' => ['Command name', ''],
      'alias' => [
        'Command alias',
        function ($vars) {
          return substr($vars['command_name'], 0, 3);
        },
      ],
      'description' => ['Command description', 'Command description.'],
      'argument' => ['Argument name', 'foo'],
      'option' => ['Option name', 'bar'],
      'command_file' => [
        'Command name',
        function ($vars) {
          $directoryBaseName = basename($this->directory);
          // The suggestion depends on whether the command global or local.
          $prefix = $directoryBaseName == 'drush' || $directoryBaseName == '.drush' ?
            $vars['command_name'] : $directoryBaseName;
          return str_replace('-', '_', $prefix) . '.drush.inc';
        },
      ],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    list($vars['command_file_prefix']) = explode('.drush.inc', $vars['command_file']);

    // Command callback name pattern gets shorter if command file name matches
    // command name.
    $vars['command_callback_suffix'] = $vars['command_file_prefix'] == str_replace('-', '_', $vars['command_name']) ?
      $vars['command_file_prefix'] : $vars['command_file_prefix'] . '_' . $vars['command_name'];

    $this->files[$vars['command_file']] = $this->render('other/drush-command.twig', $vars);
  }

}
