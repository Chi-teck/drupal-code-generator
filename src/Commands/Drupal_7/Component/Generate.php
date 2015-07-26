<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\Component;

use DrupalCodeGenerator\Commands\Generate as BaseGenerate;

/**
 * Implements generate:d7 command.
 */
class Generate extends BaseGenerate {

  protected $activeMenuItems = ['d7', 'component'];
  protected $name = 'generate:d7:component';
  protected $description = 'Generate Drupal 7 component';

}
