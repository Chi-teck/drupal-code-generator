<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d8:yml:services command.
 */
class Services extends ModuleGenerator {

  protected $name = 'd8:yml:services';
  protected $description = 'Generates a services yml file';
  protected $alias = 'services';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions = Utils::moduleQuestions();

    $vars = &$this->collectVars($questions);
    $vars['class'] = Utils::camelize($vars['name']);

    $this->addFile()
      ->path('{machine_name}.services.yml')
      ->template('d8/yml/services.twig');
  }

}
