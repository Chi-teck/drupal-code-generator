<?php

namespace DrupalCodeGenerator\Command;

/**
 * Implements theme-file command.
 */
final class ThemeFile extends ThemeGenerator {

  protected $name = 'theme-file';
  protected $description = 'Generates a theme file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.theme', 'theme');
  }

}
