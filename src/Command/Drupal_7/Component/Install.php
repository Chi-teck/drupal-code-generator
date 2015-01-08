<?php

namespace DrupalCodeGenerator\Command\Drupal_7\Component;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;

class Install extends BaseGenerator {

  protected static  $name = 'generate:d7:component:install-file';
  protected static $description = 'Generate Drupal 7 .install file';

  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'getDirectoryBaseName']],
      'machine_name' => ['Module machine name', [$this, 'default_machine_name']],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['machine_name'] . '.install'] = $this->render('d7/install.twig', $vars);

  }

}
