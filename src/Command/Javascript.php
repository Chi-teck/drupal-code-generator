<?php

namespace DrupalCodeGenerator\Command;

/**
 * Implements javascript command.
 */
class Javascript extends ModuleGenerator {

  protected $name = 'javascript';
  protected $description = 'Generates Drupal 8 JavaScript file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('js/{machine_name|u2h}.js', 'javascript');
  }

}
