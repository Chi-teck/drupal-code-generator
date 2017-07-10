<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:yml:routing command.
 */
class Routing extends BaseGenerator {

  protected $name = 'd8:yml:routing';
  protected $description = 'Generates a routing yml file';
  protected $alias = 'routing';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $vars = $this->collectVars($input, $output, Utils::defaultQuestions());
    $vars['class'] = Utils::camelize($vars['machine_name']) . 'Controller';
    $this->setFile($vars['machine_name'] . '.routing.yml', 'd8/yml/routing.twig', $vars);
  }

}
