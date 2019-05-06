<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d8:yml:routing command.
 */
class Routing extends ModuleGenerator {

  protected $name = 'd8:yml:routing';
  protected $description = 'Generates a routing yml file';
  protected $alias = 'routing';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions = Utils::moduleQuestions();

    $vars = &$this->collectVars($questions);
    $vars['class'] = Utils::camelize($vars['machine_name']) . 'Controller';

    $this->addFile()
      ->path('{machine_name}.routing.yml')
      ->template('d8/yml/routing.twig');
  }

}
