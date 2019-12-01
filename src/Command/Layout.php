<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Asset;

/**
 * Implements layout command.
 */
final class Layout extends ModuleGenerator {

  protected $name = 'layout';
  protected $description = 'Generates a layout';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {

    $vars = &$this->collectDefault();

    $vars['layout_name'] = $this->ask('Layout name', 'Example');
    $vars['layout_machine_name'] = $this->ask('Layout machine name', '{layout_name|h2m}');
    $vars['category'] = $this->ask('Category', 'My layouts');

    $vars['js'] = $this->confirm('Would you like to create JavaScript file for this layout?', FALSE);
    $vars['css'] = $this->confirm('Would you like to create CSS file for this layout?', FALSE);

    $this->addFile('{machine_name}.layouts.yml', 'layouts')
      ->action(Asset::ACTION_APPEND);

    if ($vars['js'] || $vars['css']) {
      $this->addFile('{machine_name}.libraries.yml', 'libraries')
        ->action(Asset::ACTION_APPEND);
    }

    $vars['layout_asset_name'] = '{layout_machine_name|u2h}';

    $this->addFile('layouts/{layout_machine_name}/{layout_asset_name}.html.twig', 'template');
    if ($vars['js']) {
      $this->addFile('layouts/{layout_machine_name}/{layout_asset_name}.js', 'javascript');
    }
    if ($vars['css']) {
      $this->addFile('layouts/{layout_machine_name}/{layout_asset_name}.css', 'styles');
    }

  }

}
