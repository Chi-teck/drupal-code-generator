<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements d7:theme command.
 */
class Theme extends ThemeGenerator {

  protected $name = 'd7:theme';
  protected $description = 'Generates Drupal 7 theme';
  protected $destination = 'themes';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['description'] = $this->ask('Theme description', 'A simple Drupal 7 theme.');
    $vars['base_theme'] = $this->ask('Base theme');

    $vars['asset_name'] = str_replace('_', '-', $vars['machine_name']);

    $this->addFile('{machine_name}/{machine_name}.info', 'd7/theme-info');
    $this->addFile('{machine_name}/template.php', 'd7/template.php');
    $this->addFile('{machine_name}/js/{asset_name}.js', 'd7/javascript');
    $this->addFile('{machine_name}/css/{asset_name}.css', 'd7/theme-css');
    $this->addDirectory('{machine_name}/templates');
    $this->addDirectory('{machine_name}/images');
  }

}
