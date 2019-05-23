<?php

namespace DrupalCodeGenerator\Command;

/**
 * Implements theme-settings command.
 */
class ThemeSettings extends ThemeGenerator {

  protected $name = 'theme-settings';
  protected $description = 'Generates Drupal 8 theme-settings.php file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('theme-settings.php', 'theme-settings-form');
    $this->addFile('config/install/{machine_name}.settings.yml', 'theme-settings-config');
    $this->addFile('config/schema/{machine_name}.schema.yml', 'theme-settings-schema');
  }

}
