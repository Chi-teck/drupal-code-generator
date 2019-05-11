<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements d8:yml:breakpoints command.
 */
class Breakpoints extends ThemeGenerator {

  protected $name = 'd8:yml:breakpoints';
  protected $description = 'Generates a breakpoints yml file';
  protected $alias = 'breakpoints';
  protected $destination = 'themes/%';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.breakpoints.yml', 'd8/yml/breakpoints');
  }

}
