<?php

namespace DrupalCodeGenerator\Command\Drupal_7\Component;

use DrupalCodeGenerator\Command\Generate as BaseGenerate;

/**
 * Implementation of generate:d7 command.
 */
class Generate extends BaseGenerate {

  protected $activeMenuItems = ['Drupal 7', 'Component'];
  protected $name = 'generate:d7:component';
  protected $description = 'Generate Drupal 7 component';

}
