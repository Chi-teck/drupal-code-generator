<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'batch',
  description: 'Generates a batch',
  templatePath: Application::TEMPLATE_PATH . '/_batch',
  type: GeneratorType::MODULE_COMPONENT
)]
final class Batch extends BaseGenerator {

  /**
   * {@inheritDoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['class'] = $ir->askClass(default: '{machine_name|camelize}Batch');
    $vars['operation_callback'] = $ir->ask('Operation callback method name', 'processItem');
    $vars['finished_callback'] = $ir->ask('Finished callback method name', 'finished');
    $assets->addFile('src/{class}.php', 'batch.twig');
  }

}
