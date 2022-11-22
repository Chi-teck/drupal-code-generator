<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'layout',
  description: 'Generates a layout',
  templatePath: Application::TEMPLATE_PATH . '/_layout',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Layout extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();

    $vars['layout_name'] = $ir->ask('Layout name', 'Example');
    $vars['layout_machine_name'] = $ir->ask('Layout machine name', '{layout_name|h2m}');
    $vars['category'] = $ir->ask('Category', '{machine_name|m2h} Layouts');

    $vars['js'] = $ir->confirm('Would you like to create JavaScript file for this layout?', FALSE);
    $vars['css'] = $ir->confirm('Would you like to create CSS file for this layout?', FALSE);

    $assets->addFile('{machine_name}.layouts.yml', 'layouts.twig')
      ->appendIfExists();

    if ($vars['js'] || $vars['css']) {
      $assets->addFile('{machine_name}.libraries.yml', 'libraries.twig')
        ->appendIfExists();
    }

    $vars['layout_asset_name'] = '{layout_machine_name|u2h}';

    $assets->addFile('layouts/{layout_machine_name}/{layout_asset_name}.html.twig', 'template.twig');
    if ($vars['js']) {
      $assets->addFile('layouts/{layout_machine_name}/{layout_asset_name}.js', 'javascript.twig');
    }
    if ($vars['css']) {
      $assets->addFile('layouts/{layout_machine_name}/{layout_asset_name}.css', 'styles.twig');
    }
  }

}
