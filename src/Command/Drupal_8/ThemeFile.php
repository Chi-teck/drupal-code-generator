<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
    $questions = [
      'name' => ['Theme name'],
      'machine_name' => ['Theme machine name'],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['machine_name'] . '.theme'] = $this->render('d8/theme.twig', $vars);
  }

}
