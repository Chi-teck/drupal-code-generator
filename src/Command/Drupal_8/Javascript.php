<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:javascript command.
 */
class Javascript extends BaseGenerator {

  protected $name = 'd8:javascript';
  protected $description = 'Generates Drupal 8 JavaScript file';
  protected $alias = 'javascript';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $vars = $this->collectVars($input, $output, Utils::defaultQuestions());
    $path = 'js/' . str_replace('_', '-', $vars['machine_name']) . '.js';
    $this->setFile($path, 'd8/javascript.twig', $vars);
  }

}
