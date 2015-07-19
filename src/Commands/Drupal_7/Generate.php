<?php

namespace DrupalCodeGenerator\Commands\Drupal_7;

use DrupalCodeGenerator\Commands\Generate as BaseGenerate;

/**
 * Implementation of generate:d7 command.
 */
class Generate extends BaseGenerate {

  protected $activeMenuItems = ['Drupal 7'];
  protected $name = 'generate:d7';
  protected $description = 'Generate Drupal 7 code';

}
