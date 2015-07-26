<?php

namespace DrupalCodeGenerator\Commands\Drupal_8;

use DrupalCodeGenerator\Commands\Generate as BaseGenerate;

/**
 * Implements generate:d8 command.
 */
class Generate extends BaseGenerate {

  protected $activeMenuItems = ['d8'];
  protected $name = 'generate:d8';
  protected $description = 'Generate Drupal 8 code';

}
