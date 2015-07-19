<?php

namespace DrupalCodeGenerator\Commands\Drupal_6\Component;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Class Info
 * @package DrupalCodeGenerator\Commands\Drupal_7\Component
 */
class Info extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected static  $name = 'generate:d6:component:info-file';

  /**
   * {@inheritdoc}
   */
  protected static $description = 'Generate Drupal 6 .info file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'description' => ['Module description', 'TODO: Write description for the module'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '6.x-1.0-dev'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $prefix = $vars['machine_name'];
    $this->files[$prefix . '.info'] = $this->render('d6/info.twig', $vars);

  }

}
