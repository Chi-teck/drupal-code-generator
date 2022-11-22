<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'install-file',
  description: 'Generates an install file',
  templatePath: Application::TEMPLATE_PATH . '/_install-file',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class InstallFile extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $assets->addFile('{machine_name}.install', 'install.twig');
  }

}
