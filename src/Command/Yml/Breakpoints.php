<?php

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements yml:breakpoints command.
 */
class Breakpoints extends ThemeGenerator {

  protected $name = 'yml:breakpoints';
  protected $description = 'Generates a breakpoints yml file';
  protected $alias = 'breakpoints';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.breakpoints.yml', 'yml/breakpoints');
  }

}
