<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements d8:theme-file command.
 */
class ThemeFile extends ThemeGenerator {

  protected $name = 'd8:theme-file';
  protected $description = 'Generates a theme file';
  protected $alias = 'theme-file';
  protected $destination = 'themes/%';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.theme', 'd8/theme');
  }

}
