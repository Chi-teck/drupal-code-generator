<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;

/**
 * Implements layout command.
 */
final class Layout extends ModuleGenerator {

  protected string $name = 'layout';
  protected string $description = 'Generates a layout';
  protected ?string $nameQuestion = NULL;
  protected string $templatePath = Application::TEMPLATE_PATH . '/layout';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {

    $this->collectDefault($vars);

    $vars['layout_name'] = $this->ask('Layout name', 'Example');
    $vars['layout_machine_name'] = $this->ask('Layout machine name', '{layout_name|h2m}');
    $vars['category'] = $this->ask('Category', 'My layouts');

    $vars['js'] = $this->confirm('Would you like to create JavaScript file for this layout?', FALSE);
    $vars['css'] = $this->confirm('Would you like to create CSS file for this layout?', FALSE);

    $this->addFile('{machine_name}.layouts.yml', 'layouts')
      ->appendIfExists();

    if ($vars['js'] || $vars['css']) {
      $this->addFile('{machine_name}.libraries.yml', 'libraries')
        ->appendIfExists();
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
