<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:javascript command.
 */
class Javascript extends ModuleGenerator {

  protected $name = 'd8:javascript';
  protected $description = 'Generates Drupal 8 JavaScript file';
  protected $alias = 'javascript';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('js/{machine_name|u2h}.js', 'd8/javascript');
  }

}
