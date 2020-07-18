<?php

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements misc:d7:javascript command.
 */
final class JavaScript extends ModuleGenerator {

  protected $name = 'misc:d7:javascript';
  protected $description = 'Generates Drupal 7 JavaScript file';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name|u2h}.js', 'javascript');
  }

}
