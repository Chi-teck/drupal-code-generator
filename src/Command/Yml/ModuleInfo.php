<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
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

  protected function generate(array &$vars, AssetCollection $assets): void {
    $interviewer = $this->createInterviewer($vars);
    $vars['machine_name'] = $interviewer->askMachineName();
    $interviewer->askName();
    $vars['name'] = $this->getHelper('module_info')->getModuleName($vars['machine_name']);
    $vars['description'] = $interviewer->ask('Description', 'Module description.', new Required());
    $vars['package'] = $interviewer->ask('Package', 'Custom');
    $vars['configure'] = $interviewer->ask('Configuration page (route name)');
    $vars['dependencies'] = $interviewer->ask('Dependencies (comma separated)');
    if ($vars['dependencies']) {
      $vars['dependencies'] = \array_map('trim', \explode(',', \strtolower($vars['dependencies'])));
    }
    $assets->addFile('{machine_name}.info.yml', 'module-info.twig');
  }

}
