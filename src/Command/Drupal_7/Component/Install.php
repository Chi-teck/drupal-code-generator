<?php

namespace DrupalCodeGenerator\Command\Drupal_7\Component;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;

class Install extends BaseGenerator {

  protected static  $name = 'generate:d7:component:install-file';
  protected static $description = 'Generate Drupal 7 .intstall file';

  protected function execute(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'getDirectoryBaseName'], TRUE],
      'machine_name' => ['Module machine name', [$this, 'default_machine_name'], TRUE],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $prefix = $vars['machine_name'];
    $files[$prefix . '.install'] = $this->twig->render('d7/install.twig', $vars);

    $this->submitFiles($input, $output, $files);

  }

}
