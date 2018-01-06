<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml\Links;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:yml:links:action command.
 */
class Action extends BaseGenerator {

  protected $name = 'd8:yml:links:action';
  protected $description = 'Generates a links.action yml file';
  protected $alias = 'action-links';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions['machine_name'] = new Question('Module machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('{machine_name}.links.action.yml')
      ->template('d8/yml/links.action.twig');
  }

}
