<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;

/**
 * Implements d8:yml:action-links command.
 */
class ActionLinks extends BaseGenerator {

  protected $name = 'd8:yml:action-links';
  protected $description = 'Generates a links.action yml file';
  protected $alias = 'action-links';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = ['machine_name' => ['Module machine name']];
    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['machine_name'] . '.links.action.yml'] = $this->render('d8/yml/links.action.yml.twig', $vars);
  }

}
