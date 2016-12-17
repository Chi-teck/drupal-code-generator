<?php

namespace DrupalCodeGenerator\Commands\Drupal_7;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Commands\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d7:module-file command.
 */
class ModuleFile extends BaseGenerator {

  protected $name = 'd7:module-file';
  protected $description = 'Generates Drupal 7 module file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $vars = $this->collectVars($input, $output, Utils::defaultQuestions());
    $this->files[$vars['machine_name'] . '.module'] = $this->render('d7/module.twig', $vars);
  }

}
