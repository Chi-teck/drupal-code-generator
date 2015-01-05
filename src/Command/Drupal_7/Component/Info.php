<?php

namespace DrupalCodeGenerator\Command\Drupal_7\Component;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;

class Info extends BaseGenerator {

  protected  $core = 7;

  protected function configure() {
    $this
      ->setName('generate:d7:component:info_file')
      ->setDescription('Generate Drupal 7 .info file');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {

    $vars_names = [
      'name',
      'machine_name',
      'description',
      'package',
      'version',
    ];
    $vars = $this->collectVars($input, $output, $vars_names, 'module');

    $prefix = $vars['machine_name'];
    $files[$prefix . '.info'] = $this->twig->render('d7-info.twig', $vars);

    $this->submitFiles($input, $output, $files);

  }

}
