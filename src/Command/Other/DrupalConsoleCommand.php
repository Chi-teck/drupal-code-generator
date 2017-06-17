<?php

namespace DrupalCodeGenerator\Command\Other;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

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

    $default_command_name = function ($vars) {
      return $vars['machine_name'] . ':example';
    };

    $questions = Utils::defaultQuestions() + [
      'command_name' => new Question('Command name', $default_command_name),
      'description' => new Question('Command description', 'Command description.'),
      'container_aware' => new ConfirmationQuestion('Make the command aware of the drupal site installation?', TRUE),
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize(str_replace(':', '_', $vars['command_name'])) . 'Command';
    $vars['command_trait'] = $vars['container_aware'] ? 'ContainerAwareCommandTrait' : 'CommandTrait';

    $path = 'src/Command/' . $vars['class'] . '.php';
    $this->setFile($path, 'other/drupal-console-command.twig', $vars);
  }

}
