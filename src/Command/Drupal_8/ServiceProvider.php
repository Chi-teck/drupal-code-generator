<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d8:service-provider command.
 */
class ServiceProvider extends ModuleGenerator {

  protected $name = 'd8:service-provider';
  protected $description = 'Generates a service provider';
  protected $alias = 'service-provider';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectVars(Utils::moduleQuestions());
    $vars['class'] = Utils::camelize($vars['name']) . 'ServiceProvider';
    $this->addFile()
      ->path('src/{class}.php')
      ->template('d8/service-provider.twig');
  }

}
