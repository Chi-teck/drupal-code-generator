<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;


class Module extends BaseGenerator {

  protected  $core = 7;

  protected function configure() {
    $this
      ->setName('generate:d7:module')
      ->setDescription('Generate Drupal 7 module');
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

    $prefix = $vars['machine_name'] . '/' . $vars['machine_name'];
    $files[$prefix . '.info'] = $this->twig->render('d7/info.twig', $vars);
    $files[$prefix . '.module'] = $this->twig->render('d7/module.twig', $vars);
    $files[$prefix . '.install'] = $this->twig->render('d7/install.twig', $vars);
    $files[$prefix . '.admin.inc'] = $this->twig->render('d7/admin.inc.twig', $vars);
    $files[$prefix . '.pages.inc'] = $this->twig->render('d7/pages.inc.twig', $vars);
    $files[$prefix . '.test'] = $this->twig->render('d7/test.twig', $vars);
    $files[$prefix . '.js'] = $this->twig->render('d7/js.twig', $vars);

    $this->submitFiles($input, $output, $files);

  }

}
