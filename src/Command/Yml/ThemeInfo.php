<?php

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements yml:theme-info command.
 */
final class ThemeInfo extends ThemeGenerator {

  protected $name = 'yml:theme-info';
  protected $description = 'Generates a theme info yml file';
  protected $alias = 'theme-info';
  protected $label = 'Info (theme)';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['base_theme'] = $this->ask('Base theme', 'classy', '::validateRequiredMachineName');
    $vars['description'] = $this->ask('Description', 'A flexible theme with a responsive, mobile-first layout.');
    $vars['package'] = $this->ask('Package', 'Custom');
    $this->addFile('{machine_name}.info.yml', 'theme-info');
  }

}
