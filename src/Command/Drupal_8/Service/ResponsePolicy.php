<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:service:response-policy command.
 */
class ResponsePolicy extends ModuleGenerator {

  protected $name = 'd8:service:response-policy';
  protected $description = 'Generates a response policy service';
  protected $alias = 'response-policy';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'Example');
    $this->addFile('src/PageCache/{class}.php', 'd8/service/response-policy');
    $this->addServicesFile()
      ->template('d8/service/response-policy.services');
  }

}
