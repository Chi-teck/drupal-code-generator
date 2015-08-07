<?php

namespace DrupalCodeGenerator\Commands\Drupal_7;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements generate:d7:module command.
 */
class Module extends BaseGenerator {

  protected static $name = 'd7:module';
  protected static $description = 'Generate Drupal 7 module';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'description' => ['Module description', 'TODO: Write description for the module'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '7.x-1.0-dev'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $prefix = $vars['machine_name'] . '/' . $vars['machine_name'];

    $this->files[$prefix . '.info'] = $this->render('d7/info.twig', $vars);
    $this->files[$prefix . '.module'] = $this->render('d7/module.twig', $vars);
    $this->files[$prefix . '.install'] = $this->render('d7/install.twig', $vars);
    $this->files[$prefix . '.admin.inc'] = $this->render('d7/admin.inc.twig', $vars);
    $this->files[$prefix . '.pages.inc'] = $this->render('d7/pages.inc.twig', $vars);
    $this->files[$prefix . '.test'] = $this->render('d7/test.twig', $vars);
    $this->files[$prefix . '.js'] = $this->render('d7/js.twig', $vars);
  }

}
