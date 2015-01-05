<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;


class Module extends BaseGenerator {

  protected  $core = 8;

  protected function configure() {
    $this
      ->setName('generate:d8:module')
      ->setDescription('Generate Drupal 8 module');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {

    $vars_names = [
      'name',
      'machine_name',
      'description',
    ];
    $vars = $this->collectVars($input, $output, $vars_names, 'module');

    $prefix = $vars['machine_name'] . '/' . $vars['machine_name'];
    $files[$prefix . '.info.yml'] = $this->twig->render('d8-info.yml.twig', $vars);
    $files[$prefix . '.module'] = $this->twig->render('d8-module.twig', $vars);
    $files[$prefix . '.install'] = $this->twig->render('d8-install.twig', $vars);

    $this->submitFiles($input, $output, $files);

  }

}
