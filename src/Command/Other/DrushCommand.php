<?php

namespace DrupalCodeGenerator\Command\Other;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;

/**
 * Class DrushCommand
 * @package DrupalCodeGenerator\Command\Other
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
      'name' => ['Command name', [$this, 'getDirectoryBaseName']],
      'description' => ['Command description', 'TODO: Write description for the command'],
      'argument' => ['Argument name', 'foo'],
      'option' => ['Option name', 'bar'],
      'file_name' => ['File name', [$this, 'default_filename']],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['file_name']] = $this->render('other/drush-command.twig', $vars);

  }

  /**
   * @param $vars
   * @return string
   */
  protected function default_filename($vars) {
    return self::human2machine($vars['name']) . '.drush.inc';
  }

}
