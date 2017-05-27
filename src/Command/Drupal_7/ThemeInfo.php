<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d7:theme-info command.
 */
class ThemeInfo extends BaseGenerator {

  protected $name = 'd7:theme-info';
  protected $description = 'Generates info file for a Drupal 7 theme';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'name' => ['Theme name'],
      'machine_name' => ['Theme machine name'],
      'description' => ['Theme description', 'A simple Drupal 7 theme.'],
      'base_theme' => ['Base theme', FALSE],
      'version' => ['Version', '7.x-1.0-dev'],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['machine_name'] . '.info'] = $this->render('d7/theme-info.twig', $vars);
  }

}
