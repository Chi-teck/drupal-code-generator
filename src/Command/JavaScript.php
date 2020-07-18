<?php

namespace DrupalCodeGenerator\Command;

/**
 * Implements javascript command.
 */
final class JavaScript extends ModuleGenerator {

  protected $name = 'javascript';
  protected $description = 'Generates Drupal 8 JavaScript file';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('js/{machine_name|u2h}.js', 'javascript');
  }

}
