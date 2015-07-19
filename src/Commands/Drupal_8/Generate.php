<?php

namespace DrupalCodeGenerator\Commands\Drupal_8;

use DrupalCodeGenerator\Commands\Generate as BaseGenerate;

/**
 * Implementation of generate:d8 command.
 */
class Generate extends BaseGenerate {

  protected $activeMenuItems = ['Drupal 8'];
  protected $name = 'generate:d8';
  protected $description = 'Generate Drupal 8 code';

}
