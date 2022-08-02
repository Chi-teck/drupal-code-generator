<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;

/**
 * Implements theme command.
 *
 * @todo: Create a SUT test for this.
 * @todo: Clean-up.
 */
#[Generator(
  name: 'theme',
  description: 'Generates Drupal theme',
  templatePath: Application::TEMPLATE_PATH . '/theme',
  type: GeneratorType::THEME,
)]
final class Theme extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['name'] = $ir->askName();
    $vars['machine_name'] = $ir->askMachineName();

    $vars['base_theme'] = Utils::human2machine($ir->ask('Base theme', 'classy'));
    $vars['description'] = $ir->ask('Description', 'A flexible theme with a responsive, mobile-first layout.');
    $vars['package'] = $ir->ask('Package', 'Custom');
    $vars['breakpoints'] = $ir->confirm('Would you like to create breakpoints?', FALSE);
    $vars['theme_settings'] = $ir->confirm('Would you like to create theme settings form?', FALSE);

    $assets->addFile('{machine_name}/{machine_name}.info.yml', 'yml/theme-info/theme-info');
    $assets->addFile('{machine_name}/{machine_name}.libraries.yml', 'yml/theme-libraries/theme-libraries');
    $assets->addFile('{machine_name}/{machine_name}.theme', 'theme');
    $assets->addFile('{machine_name}/js/{machine_name|u2h}.js', 'theme/js/theme.twig');

    if ($vars['breakpoints']) {
      $assets->addFile('{machine_name}/{machine_name}.breakpoints.yml', 'yml/breakpoints/breakpoints');
    }

    // @todo Do not reuse templates from other generators.
    if ($vars['theme_settings']) {
      $assets->addFile('{machine_name}/theme-settings.php', 'theme-settings/form');
      $assets->addFile('{machine_name}/config/install/{machine_name}.settings.yml', 'theme-settings/config');
      $assets->addFile('{machine_name}/config/schema/{machine_name}.schema.yml', 'theme-settings/schema');
    }

    $assets->addFile('{machine_name}/logo.svg', 'theme/logo');

    // Templates directory structure.
    $assets->addDirectory('{machine_name}/templates/page');
    $assets->addDirectory('{machine_name}/templates/node');
    $assets->addDirectory('{machine_name}/templates/field');
    $assets->addDirectory('{machine_name}/templates/view');
    $assets->addDirectory('{machine_name}/templates/block');
    $assets->addDirectory('{machine_name}/templates/menu');
    $assets->addDirectory('{machine_name}/images');

    $assets->addFile('{machine_name}/package.json', 'theme/package.json');

    // Style sheets directory structure.
    $assets->addDirectory('{machine_name}/css');

    $style_sheets = [
      'base/elements.css',
      'components/block.css',
      'components/breadcrumb.css',
      'components/field.css',
      'components/form.css',
      'components/header.css',
      'components/menu.css',
      'components/messages.css',
      'components/node.css',
      'components/sidebar.css',
      'components/table.css',
      'components/tabs.css',
      'components/buttons.css',
      'layouts/layout.css',
      'theme/print.css',
    ];
    foreach ($style_sheets as $file) {
      $assets->addFile('{machine_name}/css/' . $file);
    }

  }

}
