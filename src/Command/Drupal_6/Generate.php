<?php

namespace DrupalCodeGenerator\Command\Drupal_6;

use DrupalCodeGenerator\Command\Generate as BaseGenerate;

/**
 * Implementation of generate:d7 command.
 */
class Generate extends BaseGenerate {

  protected $activeMenuItems = ['Drupal 6'];
  protected $name = 'generate:d6';
  protected $description = 'Generate Drupal 6 code';

}
