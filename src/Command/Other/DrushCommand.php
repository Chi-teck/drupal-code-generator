<?php

namespace DrupalCodeGenerator\Command\Other;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;


class DrushCommand extends BaseGenerator {

  protected static  $name = 'generate:other:drush-command';
  protected static $description = 'Generate Drush command';

  protected function execute(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Command name', [$this, 'default_name'], TRUE],
      'description' => ['Command description', 'TODO: Write description for the command'],
      'argument' => ['Argument', 'foo'],
      'option' => ['Option name', 'bar'],
      'file_name' => ['File name', [$this, 'default_filename']],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $files[$vars['file_name']] = $this->render('other/drush-command.twig', $vars);

    $this->submitFiles($input, $output, $files);

  }

  protected function default_filename($vars) {
    return self::human2machine($vars['name']) . '.drush.inc';
  }

}
