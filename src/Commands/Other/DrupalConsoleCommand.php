<?php

namespace DrupalCodeGenerator\Commands\Other;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
    $questions = Utils::defaultQuestions() + [
      'command_name' => [
        'Command name',
        function ($vars) {
          return $vars['machine_name'] . ':example';
        },
      ],
      'description' => ['Command description', 'Command description.'],
      'container_aware' => ['Make the command aware of the drupal site installation?', 'yes'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize(str_replace(':', '_', $vars['command_name'])) . 'Command';
    $vars['command_trait'] = $vars['container_aware'] ? 'ContainerAwareCommandTrait' : 'CommandTrait';

    $path = 'src/Command/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('other/drupal-console-command.twig', $vars);
  }

}
