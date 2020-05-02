<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:access-checker command.
 */
final class AccessChecker extends ModuleGenerator {

  protected $name = 'service:access-checker';
  protected $description = 'Generates an access checker service';
  protected $alias = 'access-checker';

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {
    $vars = &$this->collectDefault();

    $validator = static function ($value) {
      if (!\preg_match('/^_[a-z0-9_]*[a-z0-9]$/', $value)) {
        throw new \UnexpectedValueException('The value is not correct name for "applies_to" property.');
      }
      return $value;
    };

    $vars['applies_to'] = $this->ask('Applies to', '_foo', $validator);
    $vars['class'] = $this->ask('Class', '{applies_to|camelize}AccessChecker');

    $this->addFile('src/Access/{class}.php', 'access-checker');
    $this->addServicesFile()->template('services');
  }

}
