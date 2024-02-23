<?php

declare(strict_types=1);

namespace Drupal\example\Generator;

use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'example:foo-bar',
  description: 'Example generator.',
  templatePath: __DIR__ . '/../../templates/generator',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class FooBarGenerator extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $vars['class'] = $ir->askClass(default: '{machine_name|camelize}');

    $assets->addFile('src/{class}.php', 'foo-bar.twig');
  }

}
