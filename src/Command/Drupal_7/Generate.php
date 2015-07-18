<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\Generate as BaseGenerate;

/**
 * Class Generate.
 */
class Generate extends BaseGenerate {

  protected $activeMenuItems = ['Drupal 7'];

  /**
   * @var string
   */
  protected $name = 'generate:d7';

  /**
   * @var string
   */
  protected $description = 'Generate Drupal 7 code';

}
