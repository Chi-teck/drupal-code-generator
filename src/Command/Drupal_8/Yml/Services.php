<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:yml:services command.
 */
class Services extends BaseGenerator {

  protected $name = 'd8:yml:services';
  protected $description = 'Generates a services yml file';
  protected $alias = 'services';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['name']);

    $this->addFile()
      ->path('{machine_name}.services.yml')
      ->template('d8/yml/services.twig');
  }

}
