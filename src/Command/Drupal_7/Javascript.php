<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d7:javascript command.
 */
class Javascript extends BaseGenerator {

  protected $name = 'd7:javascript';
  protected $description = 'Generates Drupal 7 JavaScript file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = $this->collectVars(Utils::moduleQuestions());
    $this->addFile()
      ->path(str_replace('_', '-', $vars['machine_name']) . '.js')
      ->template('d7/javascript.twig');
  }

}
