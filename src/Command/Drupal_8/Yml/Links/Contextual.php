<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml\Links;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:yml:links:contextual command.
 */
class Contextual extends BaseGenerator {

  protected $name = 'd8:yml:links:contextual';
  protected $description = 'Generates links.contextual yml file';
  protected $alias = 'contextual-links';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions['machine_name'] = new Question('Module machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);

    $vars = $this->collectVars($input, $output, $questions);

    $this->setFile($vars['machine_name'] . '.links.contextual.yml', 'd8/yml/links.contextual.twig', $vars);
  }

}
