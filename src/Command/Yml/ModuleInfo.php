<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\Required;

#[Generator(
  name: 'yml:module-info',
  description: 'Generates a module info yml file',
  aliases: ['module-info'],
  templatePath: Application::TEMPLATE_PATH . '/yml/module-info',
  type: GeneratorType::MODULE_COMPONENT,
  label: 'Info (module)',
)]
final class ModuleInfo extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $vars['description'] = $ir->ask('Description', 'Module description.', new Required());
    $vars['package'] = $ir->ask('Package', 'Custom');
    $vars['configure'] = $ir->ask('Configuration page (route name)');
    $vars['dependencies'] = $ir->ask('Dependencies (comma separated)');
    if ($vars['dependencies']) {
      $vars['dependencies'] = \array_map('trim', \explode(',', \strtolower($vars['dependencies'])));
    }
    $assets->addFile('{machine_name}.info.yml', 'module-info.twig');
  }

}
