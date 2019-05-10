<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:service:request-policy command.
 */
class RequestPolicy extends ModuleGenerator {

  protected $name = 'd8:service:request-policy';
  protected $description = 'Generates a request policy service';
  protected $alias = 'request-policy';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'Example');
    $this->addFile('src/PageCache/{class}.php', 'd8/service/request-policy');
    $this->addServicesFile()
      ->template('d8/service/request-policy.services');
  }

}
