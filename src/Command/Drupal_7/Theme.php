<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d7:theme command.
 */
class Theme extends BaseGenerator {

  protected $name = 'd7:theme';
  protected $description = 'Generates Drupal 7 theme';
  protected $destination = 'themes';

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
    $vars['project_type'] = 'theme';

    $this->files[$vars['machine_name'] . '/' . $vars['machine_name'] . '.info'] = $this->render('d7/theme-info.twig', $vars);
    $this->files[$vars['machine_name'] . '/template.php'] = $this->render('d7/template.php.twig', $vars);
    $this->files[$vars['machine_name'] . '/css/' . str_replace('_', '-', $vars['machine_name']) . '.css'] = '';
    $this->files[$vars['machine_name'] . '/js/' . str_replace('_', '-', $vars['machine_name']) . '.js'] = $this->render('d7/javascript.twig', $vars);
    $this->files[$vars['machine_name'] . '/templates'] = NULL;
    $this->files[$vars['machine_name'] . '/images'] = NULL;
  }

}
