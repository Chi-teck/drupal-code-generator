<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Yml;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Commands\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:yml:services command.
 */
class Services extends BaseGenerator {

  protected $name = 'd8:yml:services';
  protected $description = 'Generates a services yml file';
  protected $alias = 'services.yml';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $vars = $this->collectVars($input, $output, Utils::defaultQuestions());
    $vars['class'] = Utils::human2class($vars['name']);
    $this->files[$vars['machine_name'] . '.services.yml'] = $this->render('d8/yml/services.yml.twig', $vars);
  }

}
