<?php

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements misc:d7:theme command.
 */
final class Theme extends ThemeGenerator {

  protected $name = 'misc:d7:theme';
  protected $description = 'Generates Drupal 7 theme';
  protected $destination = 'themes';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['description'] = $this->ask('Theme description', 'A simple Drupal 7 theme.');
    $vars['base_theme'] = $this->ask('Base theme');
    $vars['asset_name'] = '{machine_name|u2h}';

    $this->addFile('{machine_name}/{machine_name}.info', 'misc/d7/theme-info');
    $this->addFile('{machine_name}/template.php', 'misc/d7/template.php');
    $this->addFile('{machine_name}/js/{asset_name}.js', 'misc/d7/javascript');
    $this->addFile('{machine_name}/css/{asset_name}.css', 'misc/d7/theme-css');
    $this->addDirectory('{machine_name}/templates');
    $this->addDirectory('{machine_name}/images');
  }

}
