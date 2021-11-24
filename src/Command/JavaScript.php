<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Utils;

/**
 * Implements javascript command.
 */
final class JavaScript extends ModuleGenerator {

  protected string $name = 'javascript';
  protected string $description = 'Generates Drupal JavaScript file';
  protected string $templatePath = Application::TEMPLATE_PATH . '/javascript';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['file_name_full'] = $this->ask('File name', '{machine_name|u2h}.js');
    $vars['file_name'] = \pathinfo($vars['file_name_full'], \PATHINFO_FILENAME);
    $vars['behavior'] = Utils::camelize($vars['machine_name'], FALSE) . Utils::camelize($vars['file_name']);
    if ($this->confirm('Would you like to create a library for this file?')) {
      $vars['library'] = $this->ask('Library name', '{file_name|h2u}');
      $this->addFile('{machine_name}.libraries.yml', 'libraries')
        ->appendIfExists();
    }
    $this->addFile('js/{file_name_full}', 'javascript');
  }

}
