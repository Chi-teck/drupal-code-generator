<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d7:javascript command.
 */
class Javascript extends ModuleGenerator {

  protected $name = 'd7:javascript';
  protected $description = 'Generates Drupal 7 JavaScript file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = $this->collectDefault();
    $this->addFile(str_replace('_', '-', $vars['machine_name']) . '.js')
      ->template('d7/javascript');
  }

}
