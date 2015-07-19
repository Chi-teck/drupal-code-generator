<?php

namespace DrupalCodeGenerator\Commands\Drupal_6;

use DrupalCodeGenerator\Commands\Generate as BaseGenerate;

/**
 * Implements generate:d7 command.
 */
class Generate extends BaseGenerate {

  protected $activeMenuItems = ['Drupal 6'];
  protected $name = 'generate:d6';
  protected $description = 'Generate Drupal 6 code';

}
