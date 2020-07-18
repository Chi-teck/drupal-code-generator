<?php

namespace DrupalCodeGenerator\Command;

/**
 * Implements theme-settings command.
 */
final class ThemeSettings extends ThemeGenerator {

  protected $name = 'theme-settings';
  protected $description = 'Generates Drupal 8 theme-settings.php file';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('theme-settings.php', 'form');
    $this->addFile('config/install/{machine_name}.settings.yml', 'config');
    $this->addFile('config/schema/{machine_name}.schema.yml', 'schema');
  }

}
