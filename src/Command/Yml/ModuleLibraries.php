<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'yml:module-libraries',
  description: 'Generates module libraries yml file',
  aliases: ['module-libraries'],
  templatePath: Application::TEMPLATE_PATH . '/Yaml/_module-libraries',
  type: GeneratorType::MODULE_COMPONENT,
  label: 'Libraries (module)',
)]
final class ModuleLibraries extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $vars['machine_name'] = $this->createInterviewer($vars)->askMachineName();
    $assets->addFile('{machine_name}.libraries.yml', 'module-libraries.twig');
  }

}
