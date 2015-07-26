<?php

namespace DrupalCodeGenerator\Commands\Drupal_7;

use DrupalCodeGenerator\Commands\Generate as BaseGenerate;

/**
 * Implements generate:d7 command.
 */
class Generate extends BaseGenerate {

  protected $activeMenuItems = ['d7'];
  protected $name = 'generate:d7';
  protected $description = 'Generate Drupal 7 code';

}
