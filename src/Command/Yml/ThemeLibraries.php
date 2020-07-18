<?php

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements yml:theme-libraries command.
 */
final class ThemeLibraries extends ThemeGenerator {

  protected $name = 'yml:theme-libraries';
  protected $description = 'Generates theme libraries yml file';
  protected $alias = 'theme-libraries';
  protected $label = 'Libraries (theme)';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.libraries.yml', 'theme-libraries');
  }

}
