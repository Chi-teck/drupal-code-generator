<?php declare(strict_types=1);

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
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.theme', 'theme');
  }

}
