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

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['asset_name'] = str_replace('_', '-', $vars['machine_name']);

    $this->addFile()
      ->path('{machine_name}/{machine_name}.info')
      ->template('d7/theme-info.twig');

    $this->addFile()
      ->path('{machine_name}/template.php')
      ->template('d7/template.php.twig');

    $this->addFile()
      ->path('{machine_name}/js/{asset_name}.js')
      ->template('d7/javascript.twig');

    $this->addFile()
      ->path('{machine_name}/css/{asset_name}.css')
      ->content('');

    $this->addDirectory()
      ->path('{machine_name}/templates');

    $this->addDirectory()
      ->path('{machine_name}/images');
  }

}
