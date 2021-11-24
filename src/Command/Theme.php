<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Utils;

/**
 * Implements theme command.
 *
 * @todo: Create a SUT test for this.
 * @todo: Clean-up.
 */
final class Theme extends ThemeGenerator {

  protected string $name = 'theme';
  protected string $description = 'Generates Drupal theme';
  protected bool $isNewExtension = TRUE;
  protected string $templatePath = Application::TEMPLATE_PATH . '/theme';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $vars['base_theme'] = Utils::human2machine($this->ask('Base theme', 'classy'));
    $vars['description'] = $this->ask('Description', 'A flexible theme with a responsive, mobile-first layout.');
    $vars['package'] = $this->ask('Package', 'Custom');
    $vars['sass'] = $this->confirm('Would you like to use SASS to compile style sheets?', FALSE);
    $vars['breakpoints'] = $this->confirm('Would you like to create breakpoints?', FALSE);
    $vars['theme_settings'] = $this->confirm('Would you like to create theme settings form?', FALSE);

    $this->addFile('{machine_name}/{machine_name}.info.yml', 'yml/theme-info/theme-info');
    $this->addFile('{machine_name}/{machine_name}.libraries.yml', 'yml/theme-libraries/theme-libraries');
    $this->addFile('{machine_name}/{machine_name}.theme', 'theme-file/theme');
    $this->addFile('{machine_name}/js/{machine_name|u2h}.js', 'theme/js/theme.twig');

    if ($vars['breakpoints']) {
      $this->addFile('{machine_name}/{machine_name}.breakpoints.yml', 'yml/breakpoints/breakpoints');
    }

    if ($vars['theme_settings']) {
      $this->addFile('{machine_name}/theme-settings.php', 'theme-settings/form');
      $this->addFile('{machine_name}/config/install/{machine_name}.settings.yml', 'theme-settings/config');
      $this->addFile('{machine_name}/config/schema/{machine_name}.schema.yml', 'theme-settings/schema');
    }

    $this->addFile('{machine_name}/logo.svg', 'theme/logo');

    // Templates directory structure.
    $this->addDirectory('{machine_name}/templates/page');
    $this->addDirectory('{machine_name}/templates/node');
    $this->addDirectory('{machine_name}/templates/field');
    $this->addDirectory('{machine_name}/templates/view');
    $this->addDirectory('{machine_name}/templates/block');
    $this->addDirectory('{machine_name}/templates/menu');
    $this->addDirectory('{machine_name}/images');

    $this->addFile('{machine_name}/package.json', 'theme/package.json');

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
      $this->addFile('{machine_name}/' . ($vars['sass'] ? "scss/$file.scss" : "css/$file.css"))
        ->content('');
    }

  }

}
