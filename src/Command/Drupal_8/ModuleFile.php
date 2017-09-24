<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:module-file command.
 */
class ModuleFile extends BaseGenerator {

  protected $name = 'd8:module-file';
  protected $description = 'Generates a module file';
  protected $alias = 'module-file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $vars = $this->collectVars($input, $output, Utils::defaultQuestions());
    $this->setFile($vars['machine_name'] . '.module', 'd8/module.twig', $vars);
  }

}
