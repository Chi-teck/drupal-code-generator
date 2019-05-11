<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\ThemeGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d8:theme command.
 *
 * @TODO: Create a SUT test for this.
 */
class Theme extends ThemeGenerator {

  protected $name = 'd8:theme';
  protected $description = 'Generates Drupal 8 theme';
  protected $alias = 'theme';
  protected $destination = 'themes';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['base_theme'] = Utils::human2machine($this->ask('Base theme', 'classy'));
    $vars['description'] = $this->ask('Description', 'A flexible theme with a responsive, mobile-first layout.');
    $vars['package'] = $this->ask('Package', 'Custom');
    $vars['sass'] = $this->confirm('Would you like to use SASS to compile style sheets?', FALSE);
    $vars['breakpoints'] = $this->confirm('Would you like to create breakpoints?', FALSE);
    $vars['theme_settings'] = $this->confirm('Would you like to create theme settings form?', FALSE);

    $this->addFile('{machine_name}/{machine_name}.info.yml', 'd8/yml/theme-info');
    $this->addFile('{machine_name}/{machine_name}.libraries.yml', 'd8/yml/theme-libraries');
    $this->addFile('{machine_name}/{machine_name}.theme', 'd8/theme');
    $this->addFile('{machine_name}/js/{machine_name|u2h}.js', 'd8/javascript');

    if ($vars['breakpoints']) {
      $this->addFile('{machine_name}/{machine_name}.breakpoints.yml', 'd8/yml/breakpoints');
    }

    if ($vars['theme_settings']) {
      $this->addFile('{machine_name}/theme-settings.php', 'd8/theme-settings-form');
      $this->addFile('{machine_name}/config/install/{machine_name}.settings.yml', 'd8/theme-settings-config');
      $this->addFile('{machine_name}/config/schema/{machine_name}.schema.yml', 'd8/theme-settings-schema');
    }

    $this->addFile('{machine_name}/logo.svg', 'd8/theme-logo');

    // Templates directory structure.
    $this->addDirectory('{machine_name}/templates/page');
    $this->addDirectory('{machine_name}/templates/node');
    $this->addDirectory('{machine_name}/templates/field');
    $this->addDirectory('{machine_name}/templates/view');
    $this->addDirectory('{machine_name}/templates/block');
    $this->addDirectory('{machine_name}/templates/menu');
    $this->addDirectory('{machine_name}/images');

    $this->addFile('{machine_name}/package.json', 'd8/theme-package.json');

    // Style sheets directory structure.
    $this->addDirectory('{machine_name}/css');

    $style_sheets = [
      'base/elements',
      'components/block',
      'components/breadcrumb',
      'components/field',
      'components/form',
      'components/header',
      'components/menu',
      'components/messages',
      'components/node',
      'components/sidebar',
      'components/table',
      'components/tabs',
      'components/buttons',
      'layouts/layout',
      'theme/print',
    ];

    foreach ($style_sheets as $file) {
      $this->addFile()
        ->path('{machine_name}/' . ($vars['sass'] ? "scss/$file.scss" : "css/$file.css"))
        ->content('');
    }

  }

}
