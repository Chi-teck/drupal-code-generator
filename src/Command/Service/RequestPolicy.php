<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:request-policy command.
 */
final class RequestPolicy extends ModuleGenerator {

  protected $name = 'service:request-policy';
  protected $description = 'Generates a request policy service';
  protected $alias = 'request-policy';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'Example');
    $this->addFile('src/PageCache/{class}.php', 'request-policy');
    $this->addServicesFile()->template('services');
  }

}
