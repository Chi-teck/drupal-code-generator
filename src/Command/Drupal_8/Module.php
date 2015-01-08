<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;

/**
 * Class Module
 * @package DrupalCodeGenerator\Command\Drupal_8
 */
class Module extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected static  $name = 'generate:d8:module';

  /**
   * {@inheritdoc}
   */
  protected static $description = 'Generate Drupal 8 module';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'getDirectoryBaseName']],
      'machine_name' => ['Module machine name', [$this, 'default_machine_name']],
      'description' => ['Module description', 'TODO: Write description for the module'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '8.x-1.0-dev'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $prefix = $vars['machine_name'] . '/' . $vars['machine_name'];
    $this->files[$prefix . '.info.yml'] = $this->render('d8/info.yml.twig', $vars);
    $this->files[$prefix . '.module'] = $this->render('d8/module.twig', $vars);
    $this->files[$prefix . '.install'] = $this->render('d8/install.twig', $vars);

  }

}
