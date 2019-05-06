<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

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
    $vars = $this->collectVars(Utils::moduleQuestions());
    $this->addFile()
      ->path('js/' . str_replace('_', '-', $vars['machine_name']) . '.js')
      ->template('d8/javascript.twig');
  }

}
