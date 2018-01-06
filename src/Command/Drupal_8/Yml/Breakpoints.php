<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:yml:breakpoints command.
 */
class Breakpoints extends BaseGenerator {

  protected $name = 'd8:yml:breakpoints';
  protected $description = 'Generates a breakpoints yml file';
  protected $alias = 'breakpoints';
  protected $destination = 'themes/%';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions['machine_name'] = new Question('Theme machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('{machine_name}.breakpoints.yml')
      ->template('d8/yml/breakpoints.twig');
  }

}
