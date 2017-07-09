<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:yml:theme-info command.
 */
class ThemeInfo extends BaseGenerator {

  protected $name = 'd8:yml:theme-info';
  protected $description = 'Generates a theme info yml file';
  protected $alias = 'theme-info';
  protected $destination = 'themes/%';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions['name'] = new Question('Theme name');
    $questions['name']->setValidator([Utils::class, 'validateRequired']);

    $questions['machine_name'] = new Question('Theme machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);

    $questions['base_theme'] = new Question('Base theme', 'classy');
    $questions['base_theme']->setValidator([Utils::class, 'validateMachineName']);

    $questions['description'] = new Question('Description', 'A flexible theme with a responsive, mobile-first layout.');

    $questions['package'] = new Question('Package', 'Custom');

    $vars = $this->collectVars($input, $output, $questions);

    $this->setFile($vars['machine_name'] . '.info.yml', 'd8/yml/theme-info.twig', $vars);
  }

}
