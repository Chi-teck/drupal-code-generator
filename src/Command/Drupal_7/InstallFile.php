<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d7:install-file command.
 */
class InstallFile extends BaseGenerator {

  protected $name = 'd7:install-file';
  protected $description = 'Generates Drupal 7 install file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $this->collectVars($input, $output, Utils::defaultQuestions());
    $this->addFile()
      ->path('{machine_name}.install')
      ->template('d7/install.twig');
  }

}
