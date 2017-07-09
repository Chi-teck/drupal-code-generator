<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:theme-file command.
 */
class ThemeFile extends BaseGenerator {

  protected $name = 'd8:theme-file';
  protected $description = 'Generates a theme file';
  protected $alias = 'theme-file';
  protected $destination = 'themes/%';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions['name'] = new Question('Theme name');
    $questions['name']->setValidator([Utils::class, 'validateRequired']);

    $questions['machine_name'] = new Question('Theme machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);

    $vars = $this->collectVars($input, $output, $questions);
    $this->setFile($vars['machine_name'] . '.theme', 'd8/theme.twig', $vars);
  }

}
