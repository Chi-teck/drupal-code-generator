<?php

namespace DrupalCodeGenerator\Command\Drupal_7\Component;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;

/**
 * Class Install
 * @package DrupalCodeGenerator\Command\Drupal_7\Component
 */
class Install extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected static  $name = 'generate:d7:component:install-file';

  /**
   * {@inheritdoc}
   */
  protected static $description = 'Generate Drupal 7 .install file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['machine_name'] . '.install'] = $this->render('d7/install.twig', $vars);

  }

}
