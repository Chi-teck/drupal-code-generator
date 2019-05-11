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
    $this->collectDefault();
    $this->addFile('{machine_name|u2h}.js', 'd7/javascript');
  }

}
