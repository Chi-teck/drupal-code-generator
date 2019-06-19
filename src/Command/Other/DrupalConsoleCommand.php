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

    $questions = Utils::moduleQuestions() + [
      'command_name' => new Question('Command name', '{machine_name}:example'),
      'description' => new Question('Command description', 'Command description.'),
      'drupal_aware' => new ConfirmationQuestion('Make the command aware of the drupal site installation?', TRUE),
    ];

    $vars = &$this->collectVars($input, $output, $questions);

    $service_short_name = str_replace(':', '_', $vars['command_name']);
    $vars['service_name'] = $vars['machine_name'] . '.' . $service_short_name;
    $vars['class'] = Utils::camelize($service_short_name) . 'Command';
    $vars['base_class'] = $vars['drupal_aware'] ? 'ContainerAwareCommand' : 'Command';

    $this->addFile('src/Command/{class}.php')
      ->template('other/drupal-console-command.twig');

    $this->addServicesFile('console.services.yml')
      ->template('other/drupal-console-command-services.twig');
  }

}
