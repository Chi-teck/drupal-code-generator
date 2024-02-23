<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;

/**
 * Implements theme command.
 */
#[Generator(
  name: 'theme',
  description: 'Generates Drupal theme',
  templatePath: Application::TEMPLATE_PATH . '/_theme',
  type: GeneratorType::THEME,
)]
final class Theme extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['name'] = $ir->askName();
    $vars['machine_name'] = $ir->askMachineName();

    $vars['base_theme'] = Utils::human2machine($ir->ask('Base theme', 'claro'));
    $vars['description'] = $ir->ask('Description', 'A flexible theme with a responsive, mobile-first layout.');
    $vars['package'] = $ir->ask('Package', 'Custom');
    $vars['breakpoints'] = $ir->confirm('Would you like to create breakpoints?', FALSE);
    $vars['theme_settings'] = $ir->confirm('Would you like to create theme settings form?', FALSE);

    $assets->addFile('{machine_name}/{machine_name}.info.yml', 'model.info.twig');
    $assets->addFile('{machine_name}/{machine_name}.libraries.yml', 'model.libraries.yml.twig');
    $assets->addFile('{machine_name}/{machine_name}.theme', 'model.theme.twig');
    $assets->addFile('{machine_name}/js/{machine_name|u2h}.js', 'js/model.js.twig');

    if ($vars['breakpoints']) {
      $assets->addFile('{machine_name}/{machine_name}.breakpoints.yml', 'model.breakpoints.yml.twig');
    }

    if ($vars['theme_settings']) {
      $assets->addFile('{machine_name}/theme-settings.php', 'theme-settings.php.twig');
      $assets->addFile('{machine_name}/config/install/{machine_name}.settings.yml', 'config/install/model.settings.yml.twig');
      $assets->addFile('{machine_name}/config/schema/{machine_name}.schema.yml', 'config/schema/model.schema.yml.twig');
    }

    $assets->addFile('{machine_name}/logo.svg', 'logo.svg.twig');

    // Templates directory structure.
    $assets->addDirectory('{machine_name}/templates/page');
    $assets->addDirectory('{machine_name}/templates/node');
    $assets->addDirectory('{machine_name}/templates/field');
    $assets->addDirectory('{machine_name}/templates/view');
    $assets->addDirectory('{machine_name}/templates/block');
    $assets->addDirectory('{machine_name}/templates/menu');
    $assets->addDirectory('{machine_name}/images');

    $assets->addFile('{machine_name}/package.json', 'package.json.twig');

    // Style sheets directory structure.
    $assets->addDirectory('{machine_name}/css');

    $style_sheets = [
      'base/elements.css',
      'component/block.css',
      'component/breadcrumb.css',
      'component/field.css',
      'component/form.css',
      'component/header.css',
      'component/menu.css',
      'component/messages.css',
      'component/node.css',
      'component/sidebar.css',
      'component/table.css',
      'component/tabs.css',
      'component/buttons.css',
      'layout/layout.css',
      'theme/print.css',
    ];
    foreach ($style_sheets as $file) {
      $assets->addFile('{machine_name}/css/' . $file);
    }

  }

}
