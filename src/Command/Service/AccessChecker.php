<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service:access-checker',
  description: 'Generates an access checker service',
  aliases: ['access-checker'],
  templatePath: Application::TEMPLATE_PATH . '/service/access-checker',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class AccessChecker extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();

    $validator = static function (mixed $value): string {
      if (!\is_string($value) && !\preg_match('/^_[a-z0-9_]*[a-z0-9]$/', $value)) {
        throw new \UnexpectedValueException('The value is not correct name for "applies_to" property.');
      }
      return $value;
    };
    $vars['applies_to'] = $ir->ask('Applies to', '_foo', $validator);

    $vars['class'] = $ir->ask('Class', '{applies_to|camelize}AccessChecker');

    $assets->addFile('src/Access/{class}.php', 'access-checker');
    $assets->addServicesFile()->template('services');
  }

}
