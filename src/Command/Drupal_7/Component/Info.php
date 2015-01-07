<?php

namespace DrupalCodeGenerator\Command\Drupal_7\Component;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;

class Info extends BaseGenerator {

  protected  $core = 7;

  protected function configure() {
    parent::configure();
    $this
      ->setName('generate:d7:component:info_file')
      ->setDescription('Generate Drupal 7 .info file');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', 'foo', TRUE],
      'machine_name' => ['Module machine name', 'foo', TRUE],
      'description' => ['Module description', 'TODO: Write description for the module'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '7.x-1.0-dev'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $prefix = $vars['machine_name'];
    $files[$prefix . '.info'] = $this->twig->render('d7/info.twig', $vars);

    $this->submitFiles($input, $output, $files);

  }

}
