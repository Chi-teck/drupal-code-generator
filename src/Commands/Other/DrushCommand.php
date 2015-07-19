<?php

namespace DrupalCodeGenerator\Commands\Other;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Class DrushCommand
 * @package DrupalCodeGenerator\Commands\Other
 */
class DrushCommand extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected static  $name = 'generate:other:drush-command';

  /**
   * {@inheritdoc}
   */
  protected static $description = 'Generate Drush command';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'command_name' => ['Command name', [$this, 'defaultMachineName']],
      'alias' => ['Command alias', [$this, 'defaultAlias']],
      'description' => ['Command description', 'TODO: Write description for the command'],
      'argument' => ['Argument name', 'foo'],
      'option' => ['Option name', 'bar'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['machine_name'] . '.drush.inc'] = $this->render('other/drush-command.twig', $vars);

  }

  /**
   * @param $vars
   * @return string
   */
  protected function defaultAlias($vars) {
    return substr($vars['command_name'], 0, 3);
  }

}
