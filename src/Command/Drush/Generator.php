<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Drush;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator as GeneratorDefinition;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;
use DrupalCodeGenerator\Validator\RegExp;
use DrupalCodeGenerator\Validator\Required;

#[GeneratorDefinition(
  name: 'drush:generator',
  description: 'Generates Drush generator',
  aliases: ['generator'],
  templatePath: Application::TEMPLATE_PATH . '/Drush/_generator',
  type: GeneratorType::MODULE_COMPONENT,
  label: 'DCG command',
)]
final class Generator extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $generator_name_validator = new RegExp('/^[a-z][a-z0-9-_:]*[a-z0-9]$/', 'The value is not correct generator name.');
    $vars['generator']['name'] = $ir->ask('Generator name', '{machine_name}:example', $generator_name_validator);
    $vars['generator']['description'] = $ir->ask('Generator description', validator: new Required());

    $sub_names = \explode(':', $vars['generator']['name']);
    $short_name = \array_pop($sub_names);

    $vars['class'] = $ir->askClass(default: Utils::camelize($short_name));
    $vars['template_name'] = $short_name;

    // Make service name using the following guides.
    // `foo:example` -> `foo.example` (not `foo:foo_example`)
    // `foo` -> `foo.foo` (not `foo`)
    $service_name = Utils::removePrefix($vars['generator']['name'], $vars['machine_name'] . ':');
    if (!$service_name) {
      $service_name = $vars['generator']['name'];
    }
    $vars['service_name'] = $vars['machine_name'] . '.' . \str_replace([':', '-'], '_', $service_name);

    $assets->addServicesFile('drush.services.yml')->template('drush.services.twig');
    $assets->addFile('src/Generator/{class}.php', 'generator.twig');
    $assets->addFile('templates/generator/{template_name}.twig', 'template.twig');
  }

}
