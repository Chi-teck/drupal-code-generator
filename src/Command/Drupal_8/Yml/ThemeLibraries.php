<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements d8:yml:theme-libraries command.
 */
class ThemeLibraries extends ThemeGenerator {

  protected $name = 'd8:yml:theme-libraries';
  protected $description = 'Generates theme libraries yml file';
  protected $alias = 'theme-libraries';
  protected $label = 'Libraries (theme)';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.libraries.yml', 'd8/yml/theme-libraries');
  }

}
