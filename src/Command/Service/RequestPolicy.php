<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:request-policy command.
 */
class RequestPolicy extends ModuleGenerator {

  protected $name = 'service:request-policy';
  protected $description = 'Generates a request policy service';
  protected $alias = 'request-policy';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'Example');
    $this->addFile('src/PageCache/{class}.php', 'service/request-policy');
    $this->addServicesFile()
      ->template('service/request-policy.services');
  }

}
