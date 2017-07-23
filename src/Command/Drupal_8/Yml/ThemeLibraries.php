<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:yml:theme-libraries command.
 */
class ThemeLibraries extends BaseGenerator {

  protected $name = 'd8:yml:theme-libraries';
  protected $description = 'Generates theme libraries yml file';
  protected $alias = 'theme-libraries';
  protected $label = 'Libraries (theme)';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions['machine_name'] = new Question('Theme machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);
    $vars = $this->collectVars($input, $output, $questions);
    $this->setFile($vars['machine_name'] . '.libraries.yml', 'd8/yml/theme-libraries.twig', $vars);
  }

}
