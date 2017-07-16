<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d7:javascript command.
 */
class Javascript extends BaseGenerator {

  protected $name = 'd7:javascript';
  protected $description = 'Generates Drupal 7 JavaScript file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $vars = $this->collectVars($input, $output, Utils::defaultQuestions());
    $path = str_replace('_', '-', $vars['machine_name']) . '.js';
    $this->setFile($path, 'd7/javascript.twig', $vars);
  }

}
