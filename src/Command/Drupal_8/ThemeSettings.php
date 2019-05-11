<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements d8:theme-settings command.
 */
class ThemeSettings extends ThemeGenerator {

  protected $name = 'd8:theme-settings';
  protected $description = 'Generates Drupal 8 theme-settings.php file';
  protected $alias = 'theme-settings';
  protected $destination = 'themes/%';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('theme-settings.php', 'd8/theme-settings-form');
    $this->addFile('config/install/{machine_name}.settings.yml', 'd8/theme-settings-config');
    $this->addFile('config/schema/{machine_name}.schema.yml', 'd8/theme-settings-schema.twig');
  }

}
