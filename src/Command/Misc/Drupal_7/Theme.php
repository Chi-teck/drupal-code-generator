<?php

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements misc:d7:theme command.
 */
final class Theme extends ThemeGenerator {

  protected $name = 'misc:d7:theme';
  protected $description = 'Generates Drupal 7 theme';
  protected $templatePath = Application::TEMPLATE_PATH . 'misc/d7';

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {
    $vars = &$this->collectDefault();

    $vars['description'] = $this->ask('Theme description', 'A simple Drupal 7 theme.');
    $vars['base_theme'] = $this->ask('Base theme');
    $vars['asset_name'] = '{machine_name|u2h}';

    $this->addFile('{machine_name}/{machine_name}.info', 'theme-info/theme-info');
    $this->addFile('{machine_name}/template.php', 'template.php/template.php');
    $this->addFile('{machine_name}/js/{asset_name}.js', 'javascript/javascript');
    $this->addFile('{machine_name}/css/{asset_name}.css', 'theme-css');
    $this->addDirectory('{machine_name}/templates');
    $this->addDirectory('{machine_name}/images');
  }

}
