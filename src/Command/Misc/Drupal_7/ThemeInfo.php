<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements misc:d7:theme-info command.
 */
final class ThemeInfo extends ThemeGenerator {

  protected $name = 'misc:d7:theme-info';
  protected $description = 'Generates info file for a Drupal 7 theme';
  protected $label = 'Info (theme)';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['description'] = $this->ask('Theme description', 'A simple Drupal 7 theme.');
    $vars['base_theme'] = $this->ask('Base theme');
    $this->addFile('{machine_name}.info', 'theme-info');
  }

}
