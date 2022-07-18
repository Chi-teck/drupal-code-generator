<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Test;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\RequiredClassName;

#[Generator(
  name: 'test:unit',
  description: 'Generates a unit test',
  aliases: ['unit-test'],
  templatePath: Application::TEMPLATE_PATH . '/test/unit',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Unit extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $vars['class'] = $ir->ask('Class', 'ExampleTest', new RequiredClassName());
    $assets->addFile('tests/src/Unit/{class}.php', 'unit');
  }

}
