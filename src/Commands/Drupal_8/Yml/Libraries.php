<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Yml;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:yml:libraries command.
 */
class Libraries extends BaseGenerator {

  protected $name = 'd8:yml:libraries';
  protected $description = 'Generates a libraries yml file';
  protected $alias = 'libraries.yml';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'project_type' => ['Project type (module/theme)', 'module'],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['machine_name'] . '.libraries.yml'] = $this->render('d8/yml/libraries.yml.twig', $vars);
  }

}
