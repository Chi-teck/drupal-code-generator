<?php

namespace DrupalCodeGenerator\Commands\Other;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

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
      'alias' => ['Command alias', [$this, 'defaultAlias']],
      'description' => ['Command description', 'Command description.'],
      'argument' => ['Argument name', 'foo'],
      'option' => ['Option name', 'bar'],
      'command_file' => ['Command name', [$this, 'defaultCommandFile']],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    list($vars['command_file_prefix']) = explode('.drush.inc', $vars['command_file']);

    // Command callback name pattern gets shorter if command file name matches
    // command name.
    $vars['command_callback_suffix'] = $vars['command_file_prefix'] == str_replace('-', '_', $vars['command_name']) ?
      $vars['command_file_prefix'] : $vars['command_file_prefix'] . '_' . $vars['command_name'];

    $this->files[$vars['command_file']] = $this->render('other/drush-command.twig', $vars);
  }

  /**
   * Returns default command file name.
   */
  protected function defaultCommandFile($vars) {
    // The suggestion depends on whether the command global or local.
    $prefix = $this->directoryBaseName == 'drush' || $this->directoryBaseName == '.drush' ?
      $vars['command_name'] : $this->directoryBaseName;
    return str_replace('-', '_', $prefix) . '.drush.inc';
  }

  /**
   * Returns default command alias.
   */
  protected function defaultAlias($vars) {
    return substr($vars['command_name'], 0, 3);
  }

}
