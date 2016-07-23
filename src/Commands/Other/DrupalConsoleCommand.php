<?php

namespace DrupalCodeGenerator\Commands\Other;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements other:drupal-console-command command.
 */
class DrupalConsoleCommand extends BaseGenerator {

  protected $name = 'other:drupal-console-command';
  protected $description = 'Generates Drupal Console command';
  protected $alias = 'drupal-console-command';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'command_name' => ['Command name', [$this, 'defaultCommandName']],
      'description' => ['Command description', 'Command description.'],
      'container_aware' => ['Make the command aware of the drupal site installation?', 'yes'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->command2class($vars['command_name']);
    $vars['command_trait'] = $vars['container_aware'] ? 'ContainerAwareCommandTrait' : 'CommandTrait';

    $path = $this->createPath('src/Command/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('other/drupal-console-command.twig', $vars);
  }

  /**
   * Returns default command name.
   */
  protected function defaultCommandName($vars) {
    return $vars['machine_name'] . ':example';
  }

  /**
   * Converts command name to PHP class name.
   */
  protected function command2class($command_name) {
    return $this->human2class(str_replace(':', '_', $command_name)) . 'Command';
  }

}
