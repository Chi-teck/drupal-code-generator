<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Test;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\RequiredClassName;

#[Generator(
  name: 'test:browser',
  description: 'Generates a browser based test',
  aliases: ['browser-test'],
  templatePath: Application::TEMPLATE_PATH . '/Test/_browser',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Browser extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $vars['class'] = $ir->ask('Class', 'ExampleTest', new RequiredClassName());
    $assets->addFile('tests/src/Functional/{class}.php', 'browser.twig');
  }

}
