<?php

namespace DrupalCodeGenerator\Command\Drupal_7\Component;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;

class Info extends BaseGenerator {

  protected static  $name = 'generate:d7:component:info-file';
  protected static $description = 'Generate Drupal 7 .info file';

  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'getDirectoryBaseName']],
      'machine_name' => ['Module machine name', [$this, 'default_machine_name']],
      'description' => ['Module description', 'TODO: Write description for the module'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '7.x-1.0-dev'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $prefix = $vars['machine_name'];
    $this->files[$prefix . '.info'] = $this->render('d7/info.twig', $vars);

  }

}
