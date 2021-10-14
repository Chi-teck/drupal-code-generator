<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:access-checker command.
 */
final class AccessChecker extends ModuleGenerator {

  protected string $name = 'service:access-checker';
  protected string $description = 'Generates an access checker service';
  protected string $alias = 'access-checker';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/access-checker';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

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
