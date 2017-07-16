<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

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
    $questions['name'] = new Question('Theme name');
    $questions['name']->setValidator([Utils::class, 'validateRequired']);
    $questions['machine_name'] = new Question('Theme machine name');
    $questions['machine_name']->setValidator([Utils::class, 'validateMachineName']);
    $questions['description'] = new Question('Theme description', 'A simple Drupal 7 theme.');
    $questions['base_theme'] = new Question('Base theme');

    $vars = $this->collectVars($input, $output, $questions);

    $this->setFile($vars['machine_name'] . '/' . $vars['machine_name'] . '.info', 'd7/theme-info.twig', $vars);
    $this->setFile($vars['machine_name'] . '/template.php', 'd7/template.php.twig', $vars);

    $this->setFile($vars['machine_name'] . '/js/' . str_replace('_', '-', $vars['machine_name']) . '.js', 'd7/javascript.twig', $vars);
    $this->files[$vars['machine_name'] . '/css/' . str_replace('_', '-', $vars['machine_name']) . '.css'] = '';
    $this->files[$vars['machine_name'] . '/templates'] = NULL;
    $this->files[$vars['machine_name'] . '/images'] = NULL;
  }

}
