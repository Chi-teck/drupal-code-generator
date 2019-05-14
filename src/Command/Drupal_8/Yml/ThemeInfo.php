<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements d8:yml:theme-info command.
 */
class ThemeInfo extends ThemeGenerator {

  protected $name = 'd8:yml:theme-info';
  protected $description = 'Generates a theme info yml file';
  protected $alias = 'theme-info';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['base_theme'] = $this->ask('Base theme', 'classy', '::validateMachineName');
    $vars['description'] = $this->ask('Description', 'A flexible theme with a responsive, mobile-first layout.');
    $vars['package'] = $this->ask('Package', 'Custom');
    $this->addFile('{machine_name}.info.yml', 'd8/yml/theme-info');
  }

}
